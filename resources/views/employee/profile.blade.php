@include('employee.head')
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
                                                <img src="{{ asset('employeeimages/' . Auth::user()->employeephoto->EmpPhotoPath) }}"
                                                    alt="Profile Picture">

                                            </div>
                                            <span>{{Auth::user()->employeeGeneral->EmailId_Vnr ?? 'Nill'}}</span>
                                            <span>{{ Auth::user()->designation->DesigName ?? 'No Designation' }}/{{Auth::user()->grade->GradeValue ?? 'Not Assign'}}</span>
                                            <h4 style="color:#000;"><b>EC-</b>{{ Auth::user()->EmpCode}}</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="profile-details">
                                                <p><strong>Vertical</strong><br><span>--</span>
                                                </p>
                                                <p><strong>Department</strong><br><span>{{Auth::user()->department->DepartmentName ?? 'Not Assign'}}</span>
                                                </p>
                                                <p><strong>Grade</strong><br><span>{{Auth::user()->grade->GradeValue ?? 'Not Assign'}}</span>
                                                </p>
                                                <p>
                                                    <strong>Date of Joining</strong><br>
                                                    <span>
                                                        {{ 
                                                        Auth::check() && Auth::user()->employeeGeneral
    ? \Carbon\Carbon::parse(Auth::user()->employeeGeneral->DateJoining)->format('j F Y')
    : '' 
                                                    }}
                                                    </span>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="profile-details">
                                                <p><strong>Function</strong><br>
                                                    <span>
                                                        {{ 
                                                            Auth::check() && Auth::user()->department
    ? Auth::user()->department->FunName
    : '' 
                                                        }}
                                                    </span>
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

                                                            <p><strong>DOB</strong><br>
                                                                <span>
                                                                    {{ 
                                                                                Auth::check() && Auth::user()->employeeGeneral && Auth::user()->employeeGeneral->DOB
    ? \Carbon\Carbon::parse(Auth::user()->employeeGeneral->DOB)->format('j F Y')
    : '' 
                                                                            }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Gender</strong><br>
                                                                <span>
                                                                    {{ 
            Auth::check() && Auth::user()->personaldetails
    ? (Auth::user()->personaldetails->Gender == 'M' ? 'Male' : (Auth::user()->personaldetails->Gender == 'F' ? 'Female' : 'Not specified'))
    : 'Not specified' 
        }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Blood Group</strong><br>
                                                                <span>
                                                                    {{ 
            Auth::check() && Auth::user()->personaldetails
    ? Auth::user()->personaldetails->BloodGroup
    : 'Not specified' 
        }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Marital Status</strong><br>
                                                                <span>
                                                                    {{ 
            Auth::check() && Auth::user()->personaldetails
    ? (Auth::user()->personaldetails->Married == 'Y' ? 'Yes' : (Auth::user()->personaldetails->Married == 'N' ? 'No' : 'Not specified'))
    : 'Not specified' 
        }}
                                                                </span>
                                                            </p>

                                                            <p><strong>Date of Marriage</strong><br>
                                                                <span>
                                                                    {{ 
            Auth::check() && Auth::user()->personaldetails && Auth::user()->personaldetails->MarriageDate
    ? \Carbon\Carbon::parse(Auth::user()->personaldetails->MarriageDate)->format('j F')
    : 'Not specified' 
        }}
                                                                </span>
                                                            </p>

                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="profile-details">
                                                            <p><strong>Personal Conctact No.</strong><br>
                                                                <span>
                                                                    {{ 
                Auth::check() && Auth::user()->personaldetails
    ? Auth::user()->personaldetails->MobileNo
    : 'Not specified' 
            }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Official Email Id</strong><br>
                                                                <span>
                                                                    {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? (Auth::user()->employeeGeneral->EmailId_Vnr ?? 'Nill')
    : 'Not specified' 
            }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Personal Email Id</strong><br>
                                                                <span>
                                                                    {{ 
                Auth::check() && Auth::user()->personaldetails
    ? Auth::user()->personaldetails->EmailId_Self
    : 'Not specified' 
            }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Pancard No.</strong><br>
                                                                <span>
                                                                    {{ 
                Auth::check() && Auth::user()->personaldetails
    ? Auth::user()->personaldetails->PanNo
    : 'Not specified' 
            }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Driving Licence No.</strong><br>
                                                                <span>
                                                                    {{ 
                Auth::check() && Auth::user()->personaldetails
    ? Auth::user()->personaldetails->DrivingLicNo
    : 'Not specified' 
            }}
                                                                </span>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                            <div class="int-tab-peragraph ">
                                                <div class="card-header"
                                                    style="background-color:#a5cccd;border-radius:0px;">
                                                    <h5><b>Bank</b></h5>
                                                </div>
                                                <div class="profile-details mt-2">
                                                    <p><strong>Bank Name</strong><br>
                                                        <span>
                                                            {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->BankName
    : 'Not specified' 
            }}
                                                        </span>
                                                    </p>
                                                    <p><strong>A/C No.</strong><br>
                                                        <span>
                                                            {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->AccountNo
    : 'Not specified' 
            }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Branch</strong><br>
                                                        <span>
                                                            {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->BrnchName
    : 'Not specified' 
            }}
                                                        </span>
                                                    </p>
                                                    <p><strong>PF No.</strong><br>
                                                        <span>
                                                            {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->PfAccountNo
    : 'Not specified' 
            }}
                                                        </span>
                                                    </p>
                                                    <p><strong>PF UAN</strong><br>
                                                        <span>
                                                            {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->PF_UAN
    : 'Not specified' 
            }}
                                                        </span>
                                                    </p>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                            <div class="int-tab-peragraph ">
                                                <div class="card-header"
                                                    style="background-color:#a5cccd;border-radius:0px;">
                                                    <h5><b>Reporting</b></h5>
                                                </div>
                                                <div class="profile-details mt-2">
                                                    <p><strong>Name:</strong><br>
                                                        <span>
                                                           {{ 
                    Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->ReportingName
    : 'Not specified' 
                }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Designation:</strong><br>
                                                        <span>{{ 
                                                            Auth::check() && Auth::user()->reportingdesignation
                                            ? Auth::user()->reportingdesignation->DesigName
                                            : 'Not specified' 
                                                        }}</span>
                                                    </p>
                                                    <p><strong>Contact No.:</strong><br>
                                                        <span>
                                                            {{ 
                                                                Auth::check() && Auth::user()->employeeGeneral
                                                ? Auth::user()->employeeGeneral->ReportingContactNo
                                                : 'Not specified' 
                                                            }}
                                                        </span>
                                                    </p>
                                                    <p><strong>Email Id:</strong><br>
                                                        <span>
                                                            {{ 
                Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->ReportingEmailId
    : 'Not specified' 
            }}
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                            <div class="mfh-machine-profile">
                                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">

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
                                    <!-- <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="profile-tab21"
                                            data-bs-toggle="tab" href="#Payslip" role="tab" aria-controls="Payslip"
                                            aria-selected="false">Payslip</a>
                                    </li> -->
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
                                                            <p>
                                                                {{ 
            Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->CurrAdd
    : 'Not specified' 
        }},<br>
                                                                City: {{ 
            Auth::check() && Auth::user()->cityDetails
    ? Auth::user()->cityDetails->CityName
    : 'Not specified' 
        }}<br>
                                                                District: Raipur<br>
                                                                State: {{ 
            Auth::check() && Auth::user()->stateDetails
    ? Auth::user()->stateDetails->StateName
    : 'Not specified' 
        }}<br>
                                                                Pin No.: {{ 
            Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->CurrAdd_PinNo
    : 'Not specified' 
        }}
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header">
                                                            <h5><b>Permanent Address</b></h5>
                                                        </div>
                                                        <div class="card-body dd-flex align-items-center">
                                                            <p>
                                                                {{ 
            Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->ParAdd
    : 'Not specified' 
        }},<br>
                                                                City: {{ 
            Auth::check() && Auth::user()->parcityDetails
    ? Auth::user()->parcityDetails->CityName
    : 'Not specified' 
        }}<br>
                                                                District: Raipur<br>
                                                                State: {{ 
            Auth::check() && Auth::user()->parstateDetails
    ? Auth::user()->parstateDetails->StateName
    : 'Not specified' 
        }}<br>
                                                                Pin No.: {{ 
            Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->ParAdd_PinNo
    : 'Not specified' 
        }}<br>
                                                                Official No.: {{ 
            Auth::check() && Auth::user()->personalDetails
    ? Auth::user()->personalDetails->MobileNo
    : 'Not specified' 
        }}<br>
                                                                Official Email Id: {{ 
            Auth::check() && Auth::user()->employeeGeneral
    ? Auth::user()->employeeGeneral->EmailId_Vnr
    : 'Not specified' 
        }}<br>
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
                                                                        <td><b>Name: </b>
                                                                            {{ 
                    Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->Emg_Person1
    : 'Not specified' 
                }}
                                                                        </td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Number: </b>
                                                                            {{ 
                    Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->Emg_Contact1
    : 'Not specified' 
                }}
                                                                        </td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Relation: </b>
                                                                            {{ 
                    Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->Emp_Relation1
    : 'Not specified' 
                }}
                                                                        </td>
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
                                                                        <td><b>Name: </b>
                                                                            {{ 
                    Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->Emg_Person2
    : 'Not specified' 
                }}
                                                                        </td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Number: </b>
                                                                            {{ 
                    Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->Emg_Contact2
    : 'Not specified' 
                }}
                                                                        </td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><b>Relation: </b>
                                                                            {{ 
                    Auth::check() && Auth::user()->contactDetails
    ? Auth::user()->contactDetails->Emp_Relation2
    : 'Not specified' 
                }}
                                                                        </td>
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
                                                            <thead class="text-center" style="background-color:#cfdce1;">
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
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->Fa_SN . ' ' . Auth::user()->familydata->FatherName
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata && Auth::user()->familydata->FatherDOB
    ? \Carbon\Carbon::parse(Auth::user()->familydata->FatherDOB)->format('j F Y')
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->FatherQuali
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->FatherOccupation
    : 'Not specified' 
            }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Mother</td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->Mo_SN . ' ' . Auth::user()->familydata->MotherName
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata && Auth::user()->familydata->MotherDOB
    ? \Carbon\Carbon::parse(Auth::user()->familydata->MotherDOB)->format('j F Y')
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->MotherQuali
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->MotherOccupation
    : 'Not specified' 
            }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Spouse</td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->HW_SN . ' ' . Auth::user()->familydata->HusWifeName
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata && Auth::user()->familydata->HusWifeDOB
    ? \Carbon\Carbon::parse(Auth::user()->familydata->HusWifeDOB)->format('j F Y')
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->HusWifeQuali
    : 'Not specified' 
            }}
                                                                    </td>
                                                                    <td>
                                                                        {{ 
                Auth::check() && Auth::user()->familydata
    ? Auth::user()->familydata->HusWifeOccupation
    : 'Not specified' 
            }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                        <div class="mt-3 d-none">
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
                                        
                                        <div class="card table-card">

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <thead class="text-center" style="background-color:#cfdce1;">
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
                                                            <thead class="text-center" style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>Language</th>
                                                                    <th>Write</th>
                                                                    <th>Read</th>
                                                                    <th>Speak</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $languageData = Auth::check() ? Auth::user()->languageData : []; 
                                                                @endphp
                                                                @if ($languageData)
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
                                                                @else
                                                                    <tr>
                                                                        <td colspan="4">No language data available.</td>
                                                                    </tr>
                                                                @endif
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
                                                            <thead class="text-center" style="background-color:#cfdce1;">
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
                                                                    $employeeExperience = Auth::check() ? Auth::user()->employeeExperience : [];
                                                                    $index = 1;
                                                                @endphp
                                                                @if (!empty($employeeExperience))
                                                                                                                        @foreach ($employeeExperience as $employeeExp)
                                                                                                                                                                                <tr>
                                                                                                                                                                                    <td>{{ $index++ }}</td>
                                                                                                                                                                                    <td>
                                                                                                                                                                                        {{ 
                                                                                                                                        $employeeExp->ExpFromDate
                                                                                                                            ? \Carbon\Carbon::parse($employeeExp->ExpFromDate)->format('j F Y')
                                                                                                                            : 'Not specified' 
                                                                                                                                    }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>
                                                                                                                                                                                        {{ 
                                                                                                                                        $employeeExp->ExpToDate
                                                                                                                            ? \Carbon\Carbon::parse($employeeExp->ExpToDate)->format('j F Y')
                                                                                                                            : 'Not specified' 
                                                                                                                                    }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>{{ $employeeExp->ExpComName ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>{{ $employeeExp->ExpDesignation ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>{{ $employeeExp->ExpTotalYear ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                </tr>
                                                                                                                        @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="6">No experience data available.</td>
                                                                    </tr>
                                                                @endif
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
                                                            <thead class="text-center" style="background-color:#cfdce1;">
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
                                                                    $companyTrainingTitles = Auth::check() ? Auth::user()->companyTrainingTitles : [];
                                                                    $index = 1;
                                                                @endphp
                                                                @if (!empty($companyTrainingTitles))
                                                                                                                        @foreach ($companyTrainingTitles as $companyTraining)
                                                                                                                                                                                <tr>
                                                                                                                                                                                    <td>{{ $index++ }}</td>
                                                                                                                                                                                    <td>{{ $companyTraining->TraTitle ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>{{ $companyTraining->TraYear ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>
                                                                                                                                                                                        {{ 
                                                                                                                                        $companyTraining->TraFrom
                                                                                                                            ? \Carbon\Carbon::parse($companyTraining->TraFrom)->format('j F Y')
                                                                                                                            : 'Not specified' 
                                                                                                                                    }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>
                                                                                                                                                                                        {{ 
                                                                                                                                        $companyTraining->TraTo
                                                                                                                            ? \Carbon\Carbon::parse($companyTraining->TraTo)->format('j F Y')
                                                                                                                            : 'Not specified' 
                                                                                                                                    }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>-</td>
                                                                                                                                                                                    <td>{{ $companyTraining->Location ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>{{ $companyTraining->Institute ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                    <td>{{ $companyTraining->TrainerName ?? 'Not specified' }}
                                                                                                                                                                                    </td>
                                                                                                                                                                                </tr>
                                                                                                                        @endforeach
                                                                @else
                                                                    <tr>
                                                                        <td colspan="9">No training data available.</td>
                                                                    </tr>
                                                                @endif
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
                                                            <thead class="text-center" style="background-color:#cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Month</th>
                                                                    <th>Download</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach (Auth::user()->employeePaySlip as $index => $payslip)
                                                                @php
                                                                    // Create a Carbon date instance from the month and year
                                                                    $date = \Carbon\Carbon::createFromDate($payslip->Year, $payslip->Month, 1);
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $index + 1 }}.</td>
                                                                    <td>{{ $date->format('F Y') }}</td> <!-- Formats as 'Month Year' -->
                                                                    
                                                                    <td>
                                                                        <!-- Pass the MonthlyPaySlipId, Month, Year, and Payslip Data directly to the printPayslip function -->
                                                                        <a href="javascript:void(0)" onclick="printPayslip('{{ $payslip->MonthlyPaySlipId }}', {{ $payslip->Month }}, {{ $payslip->Year }}, '{{ json_encode($payslip) }}')" class="text-dark">
                                                                            <i style="font-size: 16px;" class="fas fa-file-pdf"></i>
                                                                        </a>
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
                                    <div class="tab-pane fade" id="Documents" role="Documents">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card-header" style="background-color:#cfdce1;">
                                                            <h5><b>General</b></h5>
                                                        </div>
                                                        <table class="table table-bordered">
                                                            <thead class="text-center">
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
                                                            <thead class="text-center">
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
                                                            <thead class="text-center">
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
                                                        <div class="mt-3 d-none">
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
                                                    <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                        <table class="table table-bordered">
                                                            <div class="card-header">
                                                                <h3 class="has-btn">Resignation Form</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <form>
                                                                    <div class="form-group">
                                                                        <label class="col-form-label"> Resignation
                                                                            Date:</label>
                                                                        <input type="date" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-form-label"> Expected
                                                                            Relieving Date (By Employee):</label>
                                                                        <input type="date" class="form-control">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Reason:</label>
                                                                        <textarea class="form-control"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="col-form-label">Upload:
                                                                            Resignation letter (duly signed)</label>
                                                                        <input type="file" class="form-control">
                                                                    </div>
                                                                    <div class="form-group text-danger">
                                                                        <!-- Added class for red text -->
                                                                        <label class="col-form-label">File format - JPEG
                                                                            or PDF, File size allow - Max 1MB.</label>
                                                                        <label class="col-form-label">Resignation letter
                                                                            to be duly signed and original to be
                                                                            couriered (forward POD on mail) to HR for
                                                                            proceeding further.</label>

                                                                    </div>

                                                                    <button type="button"
                                                                        class="effect-btn btn btn-success mr-2 sm-btn">Update</button>
                                                                </form>
                                                            </div>
                                                        </table>
                                                    </div>
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
                                        <span style="background-color: #dba62f;margin-top:0px;" class="exp-round">&nbsp;</span>
                                        <div class="exp-line">
                                            <h6 class="mb-2" style="color:#9f9f9f;">{{ $employeeDataDuration->DepartmentName ?? 'N/A' }}</h6>
                                            <h5>{{ $employeeDataDuration->CompanyName ?? 'N/A' }}</h5>
                                            <p>
                                                <!-- Display DateJoining and DateOfSepration as 'M Y' -->
                                                {{ $employeeDataDuration->DateJoining ?? 'N/A' }} - 
                                                {{ $employeeDataDuration->DateOfSepration ?? 'N/A' }} 
                                            </p>

                                            <p>
                                                <!-- Calculate the duration between DateJoining and DateOfSeparation -->
                                                @php
                                                    $joinDate = \Carbon\Carbon::parse($employeeDataDuration->DateJoining);
                                                    $separationDate = \Carbon\Carbon::parse($employeeDataDuration->DateOfSepration);
                                                    $duration = $joinDate->diff($separationDate);
                                                    $years = $duration->y;
                                                    $months = $duration->m;
                                                @endphp
                                                {{ $years }} Year {{ $months }} Month
                                            </p>

                                            <div class="vnr-exp-box">
                                                <img alt="" style="width: 97px;margin-left: -14px;" src="./images/star-1.png" />
                                                <span>{{ $years }}</span>
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
        <script src="{{ asset('../js/dynamicjs/profile.js/') }}" defer></script>
