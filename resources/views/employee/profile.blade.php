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
                        <div class="user-info-wrapper header-links">
                            <a href="javascript:void(0);" class="user-info">
                                <img src="./images/user.jpg" alt="" class="user-img">
                                <div class="blink-animation">
                                    <span class="blink-circle t-present-b"></span>
                                    <span class="main-circle t-present"></span>
                                </div>
                            </a>
                            <div class="user-info-box">
                                <div class="drop-down-header">
                                    <h4>Rohit Kumar</h4>
                                    <p>Executive IT</p>
                                    <p>Emp. Code - 1254</p>
                                </div>
                                <ul>
                                    <li>
                                        <a href="{{route('profile')}}">
                                            <i class="far fa-user"></i> Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fas fa-cog"></i> Change Passward
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </a>
                                        <form id="logout-form-1" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
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
                                    <li class="breadcrumb-link active">Profile</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->

                <div class="row">
                    <!-- Revanue Status Start -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-none">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="">

                                <div class="emp-profile-sec">
                                    <img alt="" class="profile-pic" src="./images/7.jpg" />
                                    <span class="edit-profile-link"><a href=""><i
                                                class="far fa-edit mr-2"></i></a></span>
                                    <div class="emp-name-profile">
                                        <h3><b>Rohit Kumar Mishra</b></h3>
                                        <h4 class="mt-2" style="color:#2bb15b;"><b>Emp. ID: 1544</b></h4>
                                    </div>
                                    <div class="float-start" style="margin-left: 55px;margin-top: 55px;">
                                        <span class="profile-name-id"><i class="fa fa-phone-alt mr-2"></i>
                                            +91-9589457812</span>
                                        <span class="profile-name-id"><i class="far fa-envelope mr-2"></i>
                                            rohitkumar.vspl@gmail.com</span>

                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="card chart-card">
                                <div class="card-body" style="min-height:375px;">
                                    <!-- Profile Picture and Name -->
                                    <div class="profile-header">
                                        <!-- <div class="profile-picture">
                                            <img src="./images/7.jpg" alt="Profile Picture">
                                        </div> -->
                                        
                                        <div class="profile-info">
                                            <h2>{{ Auth::user()->Fname . ' ' . Auth::user()->Sname . '' . Auth::user()->Lname }}
                                            </h2>
                                            <div class="profile-picture">
                                            <img src="{{asset(Auth::user()->employeephoto->EmpPhotoPath)}}" alt="Profile Picture">
                                            </div>
                                            <span>{{Auth::user()->employeeGeneral->EmailId_Vnr ?? 'Nill'}}/span>
                                                <h4 style="color:#000;">{{ Auth::user()->EmpCode}}</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="profile-details">
                                                <p><strong>Designation</strong><br><span>{{ Auth::user()->designation->DesigName ?? 'No Designation' }}</span>
                                                </p>
                                                <p><strong>Department</strong><br><span>{{Auth::user()->department->DepartmentName ?? 'Not Assign'}}</span>
                                                </p>
                                                <p><strong>Grade</strong><br><span>{{Auth::user()->grade->GradeValue ?? 'Not Assign'}}</span>
                                                </p>
                                                <p><strong>Date of
                                                        Joining</strong><br><span>{{Auth::user()->employeeGeneral->DateJoining}}</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="profile-details">
                                                <p><strong>Function</strong><br><span>{{Auth::user()->department->FunName}}</span>
                                                </p>
                                                <p><strong>Region</strong><br><span>-</span></p>
                                                <p><strong>Zone</strong><br><span>-</span></p>
                                                <p><strong>HQ</strong><br><span>Raipur</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
                            <div class="card chart-card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="int-tab-peragraph">
                                                <div class="card-header"
                                                    style="background-color:#a5cccd;border-radius:0px;">
                                                    <h5><b>Personal</b></h5>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="profile-details">
                                                            <p><strong>DOB</strong><br><span>{{Auth::user()->employeeGeneral->DOB}}</span>
                                                            </p>
                                                            <p><strong>Gender</strong><br><span>{{ Auth::user()->personaldetails->Gender == 'M' ? 'Male' : (Auth::user()->personaldetails->Gender == 'F' ? 'Female' : 'Not specified') }}
                                                                </span></p>
                                                            <p><strong>Blood
                                                                    Group</strong><br><span>{{Auth::user()->personaldetails->BloodGroup}}</span>
                                                            </p>
                                                            <p><strong>Marital
                                                                    Status</strong><br><span>{{Auth::user()->personaldetails->Married == 'Y' ? 'Yes' : (Auth::user()->personaldetails->Married == 'N' ? 'No' : '')}}</span>
                                                            </p>
                                                            <p><strong>Date of
                                                                    Marriage</strong><br><span>{{Auth::user()->personaldetails->MarriageDate}}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="profile-details">
                                                            <p><strong>Personal
                                                                    No.</strong><br><span>{{Auth::user()->personaldetails->MobileNo}}</span>
                                                            </p>
                                                            <p><strong>Official Email
                                                                    Id</strong><br><span>{{Auth::user()->employeeGeneral->EmailId_Vnr ?? 'Nill'}}</span>
                                                            </p>
                                                            <p><strong>Personal Email
                                                                    Id</strong><br><span>{{Auth::user()->personaldetails->EmailId_Self}}</span>
                                                            </p>
                                                            <p><strong>Pancard
                                                                    No.</strong><br><span>{{Auth::user()->personaldetails->PanNo}}</span>
                                                            </p>
                                                            <p><strong>Driving Licence
                                                                    No.</strong><br><span>{{Auth::user()->personaldetails->DrivingLicNo}}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="table table-pad d-none">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>DOB:</b></td>
                                                            <td>12-07-1996</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gender:</b></td>
                                                            <td>Male</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Blood Group:</b></td>
                                                            <td>B+</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Marital Status:</b></td>
                                                            <td>Married</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Date of Marriage:</b></td>
                                                            <td>15-05-2020</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Personal No.:</b></td>
                                                            <td>+91-95894-57812</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Official Email Id:</b></td>
                                                            <td>rohitkumar.vspl@gmail.com</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Personal Email Id:</b></td>
                                                            <td>rohitkumar@gmail.com</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                            <div class="int-tab-peragraph ">
                                                <div class="card-header"
                                                    style="background-color:#a5cccd;border-radius:0px;">
                                                    <h5><b>Bank</b></h5>
                                                </div>
                                                <div class="profile-details mt-2">
                                                    <p><strong>Bank</strong><br><span>{{Auth::user()->employeeGeneral->BankName}}</span>
                                                    </p>
                                                    <p><strong>A/C
                                                            No.</strong><br><span>{{Auth::user()->employeeGeneral->AccountNo}}</span>
                                                    </p>
                                                    <p><strong>Branch</strong><br><span>{{Auth::user()->employeeGeneral->BrnchName}}</span>
                                                    </p>
                                                    <p><strong>PF
                                                            No.</strong><br><span>{{Auth::user()->employeeGeneral->PfAccountNo}}</span>
                                                    </p>
                                                    <p><strong>PF UAN</strong><br>
                                                        <span>{{Auth::user()->employeeGeneral->PF_UAN}}</span>
                                                    </p>
                                                </div>
                                                <table class="table table-pad d-none">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Name:</b></td>
                                                            <td>{{Auth::user()->employeeGeneral->ReportingName}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Designation:</b></td>
                                                            <td>{{Auth::user()->reportingdesignation->DesigName}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Contact No.:</b></td>
                                                            <td>{{Auth::user()->employeeGeneral->ReportingContactNo}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Email Id:</b></td>
                                                            <td>{{Auth::user()->employeeGeneral->ReportingEmailId}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                            <div class="int-tab-peragraph ">
                                                <div class="card-header"
                                                    style="background-color:#a5cccd;border-radius:0px;">
                                                    <h5><b>Reporting</b></h5>
                                                </div>
                                                <div class="profile-details mt-2">
                                                    <p><strong>Name.</strong><br><span>{{Auth::user()->employeeGeneral->ReportingName}}</span>
                                                    </p>
                                                    <p><strong>Designation</strong><br><span>Manager IT</span></p>
                                                    <p><strong>Contact
                                                            No.</strong><br><span>{{Auth::user()->employeeGeneral->ReportingContactNo}}</span>
                                                    </p>
                                                    <p><strong>Email
                                                            Id</strong><br><span>{{Auth::user()->employeeGeneral->ReportingEmailId}}</span>
                                                    </p>
                                                </div>
                                                <table class="table table-pad d-none">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Name:</b></td>
                                                            <td>Mr. Ajay Kumar Dewangan</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Designation:</b></td>
                                                            <td>Manager IT</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Contact No.:</b></td>
                                                            <td>9589457815</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Email Id:</b></td>
                                                            <td>ajay.dewangan@vnrseeds.in</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="mfh-machine-profile">
                                <ul class="nav nav-tabs" id="myTab1" role="tablist"
                                    style="background-color:#a5cccd;border-radius: 10px 10px 0px 0px;">


                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link active" id="profile-tab21"
                                            data-bs-toggle="tab" href="#ContactTab" role="tab"
                                            aria-controls="ContactTab" aria-selected="false">Contact Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#EducationTab" role="tab"
                                            aria-controls="EducationTab" aria-selected="false">Education</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#FamilyTab" role="tab" aria-controls="FamilyTab"
                                            aria-selected="false">Family</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Language" role="tab" aria-controls="Language"
                                            aria-selected="false">Language</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Training" role="tab" aria-controls="Training"
                                            aria-selected="false">Training</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Payslip" role="tab" aria-controls="Payslip"
                                            aria-selected="false">Payslip</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Experience" role="tab"
                                            aria-controls="Experience" aria-selected="false">Experience</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Documents" role="tab" aria-controls="Documents"
                                            aria-selected="false">Documents</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Separation" role="tab"
                                            aria-controls="Separation" aria-selected="false">Separation</a>
                                    </li>
                                </ul>
                                <div class="tab-content ad-content2" id="myTabContent2">
                                    <div class="tab-pane fade " id="GeneralTab" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                        <div class="card-header" style="background-color:#f1f1f1;">
                                                            <h5><b>Employee Details</b></h5>
                                                        </div>
                                                        <div class="card-body dd-flex align-items-center">

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="PersonalTab" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">


                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="row">
                                                                    <div
                                                                        class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                                        <h6>If you want change DOB/DOM</h6>
                                                                        <div class="form-group s-opt mt-2">
                                                                            <label for="city"
                                                                                class="col-form-label">Select</label>
                                                                            <select
                                                                                class="select2 form-control select-opt"
                                                                                id="city">
                                                                                <option value="DOB">Date Of Birth
                                                                                </option>
                                                                                <option value="DOM">Date Of Married
                                                                                </option>
                                                                            </select>
                                                                            <span class="sel_arrow">
                                                                                <i class="fa fa-angle-down "></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group s-opt">
                                                                            <label for="city"
                                                                                class="col-form-label">Current
                                                                                Date</label>
                                                                            <input class="form-control" type="date"
                                                                                placeholder="Enter DOB" id="dob"
                                                                                fdprocessedid="s30b74">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group s-opt">
                                                                            <label for="city"
                                                                                class="col-form-label">Correct
                                                                                Date</label>
                                                                            <input class="form-control" type="date"
                                                                                placeholder="Enter DOB" id="dob"
                                                                                fdprocessedid="s30b74">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="form-group mb-0">
                                                                <button class="sm-btn btn-outline success-outline"
                                                                    type="button" fdprocessedid="ivpmxx">Submit</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade active show" id="ContactTab" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header">
                                                            <h5><b>Current Address</b></h5>
                                                        </div>
                                                        <div class="card-body dd-flex align-items-center">
                                                            <p>{{Auth::user()->contactDetails->CurrAdd}},<br>
                                                                City: {{Auth::user()->cityDetails->CityName}}<br>
                                                                District: Raipur<br>
                                                                State: {{Auth::user()->stateDetails->StateName}}<br>
                                                                Pin No.: {{Auth::user()->contactDetails->CurrAdd_PinNo}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header">
                                                            <h5><b>Permanent Address</b></h5>
                                                        </div>
                                                        <div class="card-body dd-flex align-items-center">
                                                            <p>{{Auth::user()->contactDetails->ParAdd}},<br>
                                                                City: {{Auth::user()->parcityDetails->CityName}}<br>
                                                                District: Raipur<br>
                                                                State: {{Auth::user()->parstateDetails->StateName}}<br>
                                                                Pin No.:
                                                                {{Auth::user()->contactDetails->ParAdd_PinNo}}<br>
                                                                Oficial No.:
                                                                {{Auth::user()->personalDetails->MobileNo}}<br>
                                                                Official Email Id:
                                                                {{Auth::user()->employeeGeneral->EmailId_Vnr}}<br>
                                                            </p>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header">
                                                            <h5><b>Emergency Contact Number 1</b></h5>
                                                        </div>
                                                        <div class="card-body dd-flex align-items-center">
                                                            <table class="table table-pad">
                                                                <tbody>
                                                                    <tr>
                                                                        <td><b>Name:{{Auth::user()->contactDetails->Emg_Person1}}</b></td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Number:{{Auth::user()->contactDetails->Emg_Contact1}}</b></td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Relation:{{Auth::user()->contactDetails->Emp_Relation1}}</b></td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header">
                                                            <h5><b>Emergency Contact Number 2</b></h5>
                                                        </div>
                                                        <div class="card-body dd-flex align-items-center">
                                                            <table class="table table-pad">
                                                            <tbody>
                                                                    <tr>
                                                                        <td><b>Name:{{Auth::user()->contactDetails->Emg_Person2}}</b></td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Number:{{Auth::user()->contactDetails->Emg_Contact2}}</b></td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Relation:{{Auth::user()->contactDetails->Emp_Relation2}}</b></td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="FamilyTab" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>Relation</th>
                                                                    <th>Name</th>
                                                                    <th>DOB</th>
                                                                    <th>Education</th>
                                                                    <th>Occupation</td>

                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td>Father</td>
                                                                    <td>{{ Auth::user()->familydata->Fa_SN . ' ' . Auth::user()->familydata->FatherName}}
                                                                    </td>
                                                                    <td>{{ Auth::user()->familydata->FatherDOB}}</td>
                                                                    <td>{{ Auth::user()->familydata->FatherQuali}}</td>
                                                                    <td>{{ Auth::user()->familydata->FatherOccupation}}
                                                                    </td>



                                                                </tr>
                                                                <tr>
                                                                    <td>Mother</td>
                                                                    <td>{{ Auth::user()->familydata->Mo_SN . ' ' . Auth::user()->familydata->MotherName}}
                                                                    </td>
                                                                    <td>{{ Auth::user()->familydata->MotherDOB}}</td>
                                                                    <td>{{ Auth::user()->familydata->MotherQuali}}</td>
                                                                    <td>{{ Auth::user()->familydata->MotherOccupation}}
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td>Spouse</td>
                                                                    <td>{{ Auth::user()->familydata->HW_SN . ' ' . Auth::user()->familydata->HusWifeName}}
                                                                    </td>
                                                                    <td>{{ Auth::user()->familydata->HusWifeDOB}}</td>
                                                                    <td>{{ Auth::user()->familydata->HusWifeQuali}}</td>
                                                                    <td>{{ Auth::user()->familydata->HusWifeOccupation}}
                                                                    </td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class="mt-3">
                                                            <a class="btn-outline success-outline sm-btn" href=""
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#AddmoreFamily">Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="EducationTab" role="tabpanel">
                                        <!------>
                                        <div class="card table-card">

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>Qualification</th>
                                                                    <th>Specialization</th>
                                                                    <th>Institute/ University</th>
                                                                    <th>Subject</th>
                                                                    <th>Grade/ Per.</th>
                                                                    <th>PassOut</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $qualifications = Auth::user()->qualificationsdata; 
                                                                @endphp


                                                                @foreach (['Below 10th', '10th', '12th', 'Graduation', 'Post Graduation'] as $qualificationType)
                                                                                                                                @php
                                                                                                                                    $qualification = $qualifications->firstWhere('Qualification', $qualificationType);
                                                                                                                                @endphp

                                                                                                                                <tr>
                                                                                                                                    <td>{{ $qualificationType }}</td>
                                                                                                                                    <td>{{ $qualification ? $qualification->Specialization : '-' }}
                                                                                                                                    </td>
                                                                                                                                    <td>{{ $qualification ? $qualification->Institute : '-' }}
                                                                                                                                    </td>
                                                                                                                                    <td>{{ $qualification ? $qualification->Subject : '-' }}
                                                                                                                                    </td>
                                                                                                                                    <td>{{ $qualification ? $qualification->Grade_Per : '-' }}
                                                                                                                                    </td>
                                                                                                                                    <td>{{ $qualification ? $qualification->PassOut : '-' }}
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>

                                                        <div class="mt-3 d-none">
                                                            <a class="btn-outline success-outline sm-btn" href=""
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#AddmoreFamily">Add more</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="chart-holder d-none">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-4"
                                                            style="text-align:center;float: left;position: relative;">
                                                            <div style="position: absolute;top:10px;left: 25%;">
                                                                <div class="year">2017</div>
                                                                <div class="year-top-arrow"></div>
                                                            </div>
                                                            <div class="" style="margin-top: 217px;">
                                                                <div class="box-y">Post Graduation</div>
                                                                <div class="p-2">
                                                                    <b>M.Sc. Agriculture</b><br>
                                                                    Chhattishgarh Board of Secondary Education
                                                                    Secondary School Certificate
                                                                    75%
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4"
                                                            style="text-align:center;float: left;position: relative;">
                                                            <div style="position: absolute;top:10px;left: 25%;">
                                                                <div class="year">2015</div>
                                                                <div class="year-top-arrow"></div>
                                                            </div>
                                                            <div class="" style="margin-top: 217px;">
                                                                <div class="box-y">Graduation</div>
                                                                <div class="p-2">
                                                                    <b>B.Sc.Agriculture</b><br>
                                                                    Pt. Sunder lal Sharma
                                                                    Secondary School Certificate
                                                                    75%
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4"
                                                            style="text-align:center;float: left;position: relative;">
                                                            <div style="position: absolute;top:10px;left: 25%;">
                                                                <div class="year">2012</div>
                                                                <div class="year-top-arrow"></div>
                                                            </div>
                                                            <div class="" style="margin-top: 217px;">
                                                                <div class="box-y">12th</div>
                                                                <div class="p-2">
                                                                    <b>All Compulsory Subjects</b><br>
                                                                    Chhattishgarh Board of Secondary Education
                                                                    Secondary School Certificate
                                                                    75%
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-4"
                                                            style="text-align:center;float: left;position: relative;">
                                                            <div style="position: absolute;top:10px;left: 25%;">
                                                                <div class="year">2010</div>
                                                                <div class="year-top-arrow"></div>
                                                            </div>
                                                            <div style="margin-top: 217px;" class="box-y">10th</div>
                                                            <div class="p-2">
                                                                <b>All Compulsory Subjects</b><br>
                                                                Chhattishgarh Board of Secondary Education
                                                                Secondary School Certificate
                                                                75%
                                                            </div>
                                                        </div>



                                                        <div class="col-md-4 mb-4"
                                                            style="text-align:center;float: left;position: relative;">
                                                            <div class="mt-5">
                                                                <a class="mt-5 btn-outline success-outline" href=""
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#AddmoreEducation">Add more</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!------------>
                                    </div>
                                    <div class="tab-pane fade" id="Language" role="Language">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>Language</th>
                                                                    <th>Write</th>
                                                                    <th>Read</th>
                                                                    <th>Speak</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @php
                                                                    $languageData = Auth::user()->languageData; 
                                                                @endphp
                                                                @foreach ($languageData as $proficiency)
                                                                    <tr>
                                                                        <td>{{ $proficiency->Language }}</td>
                                                                        <td>{{ $proficiency->Write_lang === 'Y' ? 'Yes' : 'No' }}
                                                                        </td>
                                                                        <td>{{ $proficiency->Read_lang === 'Y' ? 'Yes' : 'No' }}
                                                                        </td>
                                                                        <td>{{ $proficiency->Speak_lang === 'Y' ? 'Yes' : 'No' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                               
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Experience" role="Experience">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Company</th>
                                                                    <th>Designation</th>
                                                                    <th>Duration</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $employeeExperience = Auth::user()->employeeExperience; 
                                                                    $index=1;
                                                                @endphp
                                                                @foreach ($employeeExperience as $employeeExp)
                                                                    <tr>
                                                                        <td>{{$index++}}</td>
                                                                        <td>{{ $employeeExp->ExpFromDate }}</td>
                                                                        <td>{{ $employeeExp->ExpToDate }}</td>
                                                                        <td>{{ $employeeExp->ExpComName }}</td>
                                                                        <td>{{ $employeeExp->ExpDesignation }}</td>
                                                                        <td>{{ $employeeExp->ExpTotalYear }}</td>
                                                                       
                                                                    </tr>
                                                                @endforeach
                                                               
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Training" role="Training">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Subject</th>
                                                                    <th>Year</th>
                                                                    <th>Date From</th>
                                                                    <th>Date To</td>
                                                                    <th>Day</td>
                                                                    <th>Location</td>
                                                                    <th>Institute</td>
                                                                    <th>Trainer</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $companyTrainingTitles = Auth::user()->companyTrainingTitles; 
                                                                    $index = 1;
                                                                @endphp
                                                                @foreach ($companyTrainingTitles as  $companyTraining)
                                                                    <tr>
                                                                        <td>{{$index++}}</td>
                                                                        <td>{{ $companyTraining->TraTitle }}</td>
                                                                        <td>{{ $companyTraining->TraYear }}</td>
                                                                        <td>{{ $companyTraining->TraFrom }}</td>
                                                                        <td>{{ $companyTraining->TraTo }}</td>
                                                                        <td>-</td>
                                                                        <td>{{ $companyTraining->Location }}</td>
                                                                        <td>{{ $companyTraining->Institute }}</td>
                                                                        <td>{{ $companyTraining->TrainerName }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                                                                           </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="Payslip" role="Payslip">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Month</th>
                                                                    <th>Download</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>May 2024</td>
                                                                    <td><a href=""><i style="font-size:15px;"
                                                                                class="fas fa-file-pdf"></i></a></td>



                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>June 2024</td>
                                                                    <td><a href=""><i style="font-size:15px;"
                                                                                class="fas fa-file-pdf"></i></a></td>

                                                                </tr>

                                                                <tr>
                                                                    <td>3.</td>
                                                                    <td>July 2024</td>
                                                                    <td><a href=""><i style="font-size:15px;"
                                                                                class="fas fa-file-pdf"></i></a></td>

                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Documents" role="Documents">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header" style="background-color:#cfdce1;">
                                                            <h5><b>General</b></h5>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Documents Name</th>
                                                                    <th>View</th>
                                                                    <th>Download</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>Passpot</td>
                                                                    <td><img style="width:30px;"
                                                                            src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;"
                                                                                class="fas fa-download"></i></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>Account Passbook</td>
                                                                    <td><img style="width:30px;"
                                                                            src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;"
                                                                                class="fas fa-download"></i></a></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3.</td>
                                                                    <td>Driving Licence No.</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>4.</td>
                                                                    <td>Pancard</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>


                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header" style="background-color:#cfdce1;">
                                                            <h5><b>Education</b></h5>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Documents Name</th>
                                                                    <th>View</th>
                                                                    <th>Download</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>10th</td>
                                                                    <td><img style="width:30px;"
                                                                            src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;"
                                                                                class="fas fa-download"></i></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>12th</td>
                                                                    <td><img style="width:30px;"
                                                                            src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;"
                                                                                class="fas fa-download"></i></a></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3.</td>
                                                                    <td>Graduation</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>

                                                                <tr>
                                                                    <td>4.</td>
                                                                    <td>Post Graduation</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header" style="background-color:#cfdce1;">
                                                            <h5><b>Others</b></h5>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Documents Name</th>
                                                                    <th>View</th>
                                                                    <th>Download</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>Passpot</td>
                                                                    <td><img style="width:30px;"
                                                                            src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;"
                                                                                class="fas fa-download"></i></a></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>Account Passbook</td>
                                                                    <td><img style="width:30px;"
                                                                            src="images/excel-invoice.jpg" /></td>
                                                                    <td><a><i style="font-size:15px;"
                                                                                class="fas fa-download"></i></a></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3.</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                    <td>-</td>
                                                                </tr>



                                                            </tbody>
                                                        </table>
                                                        <div class="mt-3">
                                                            <a class="btn-outline success-outline sm-btn" href=""
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#AddmoreFamily">Add more</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="Separation" role="Separation">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    Separation
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                            <div class="card chart-card">
                                <div class="card-header">
                                    <h4 class="has-btn">Change Request</h4>
                                    <p>For any change in data, notify HR with supporting documents </p>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label class="col-form-label">Subject:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Attached files:</label>
                                            <input type="file" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Message:</label>
                                            <textarea class="form-control"></textarea>
                                        </div>
                                        <button type="button"
                                            class="effect-btn btn btn-success mr-2 sm-btn">Update</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card chart-card mt-3">
                                <div class="card-header">
                                    <h4 class="has-btn">Employment Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="exp-details-box">
                                        <span style="background-color: #dba62f;margin-top:0px;"
                                            class="exp-round">&nbsp;</span>
                                        <div class="exp-line">
                                            <h6 class="mb-2" style="color:#9f9f9f;">Sr. Bussiness Manager</h6>
                                            <h5>VNR Seeds Pvt. Ltd. Raipur</h5>
                                            <p>Jan 2020 - June 2023</p>
                                            <p>5 Year 2 Month</p>
                                            <div class="vnr-exp-box">
                                                <img alt="" style="width: 97px;margin-left: -14px;"
                                                    src="./images/star-1.png" />
                                                <span>5</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="ad-footer-btm">
                        <p><a href="">Tarms of use </a> | <a href="">Privacy Policy</a> © Copyright 2023 VNR Seeds
                            Private Limited India.</p>
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

        <!--Contact Details -->
        <div class="modal fade show" id="model3" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3">Change Request Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <form>
                            <div class="form-group">
                                <label class="col-form-label">Subject:</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Attached files:</label>
                                <input type="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Message:</label>
                                <textarea class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!--Add Education Details -->
        <div class="modal fade show" id="AddmoreEducation" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3">Add New Education</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Qualification:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Specialization:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Institute/ University:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Subject:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Grade/ Per.:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">PassOut:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Message:</label>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Add Family Details -->
        <div class="modal fade show" id="AddmoreFamily" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            style="display: none;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle3">Add New Family Member</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <form>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Relation:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Name:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">DOB:</label>
                                    <input type="date" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Education:</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label class="col-form-label">Occupation:</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
        @include('employee.footer');
