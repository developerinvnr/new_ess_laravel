@include('employee.header')

<body class="mini-sidebar">
    @include('employee.sidebar')
    <div id="loader" style="display: none;">
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
                                    <li class="breadcrumb-link active">Single Profile</li>
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
                                <div class="card-body" style="min-height:414px;">
                                    <!-- Profile Picture and Name -->
                                    <div class="profile-header">
                                        <!-- <div class="profile-picture">
                                            <img src="./images/7.jpg" alt="Profile Picture">
                                        </div> -->

                                        <div class="profile-info">
                                            <h2>{{$employee->Fname .' '.$employee->Sname .' '.$employee->Lname}}
                                            </h2>
                                            <div class="profile-picture">
                                                <!-- <img src="{{ asset('employeeimages/' . Auth::user()->employeephoto->EmpPhotoPath) }}"
                                                    alt="Profile Picture"> -->
                                                <img src="https://vnrseeds.co.in/AdminUser/EmpImg1Emp/{{$employee->EmpCode}}.jpg"
                                                    alt="Profile Picture">


                                            </div>
                                            <span>{{$employee->EmailId_Vnr ?? 'Nill'}}</span>
                                            <br>
                                            <span>{{ $employee->DesigName ?? '' }}
                                                <!-- /{{Auth::user()->grade->GradeValue ?? 'Not Assign'}} -->
                                            </span>
                                            <h4 style="color:#000;"><b>EC-</b>{{ $employee->EmpCode}}</h4>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="profile-details">
                                                <p><strong>Vertical</strong><br><span>{{$employee->VerticalName ?? '-'}}</span>
                                                </p>
                                                <p><strong>Department</strong><br><span>{{$employee->DepartmentName ?? 'Not Assign'}}</span>
                                                </p>
                                                <p><strong>Grade</strong><br><span>{{$employee->GradeValue ?? 'Not Assign'}}</span>
                                                </p>
                                                <p>
                                                    <strong>Date of Joining</strong><br>
                                                    <span>
                                                        {{ 
                                                        \Carbon\Carbon::parse($employee->DateJoining)->format('j F Y')
                                                             
                                                    }}
                                                    </span>
                                                </p>

                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                            <div class="profile-details">
                                                <!-- <p><strong>Function</strong><br>
                                                    <span>
                                                        {{ 
                                                            Auth::check() && Auth::user()->department
                                                                ? Auth::user()->department->FunName
                                                                : '' 
                                                        }}
                                                    </span>
                                                </p> -->
                                                <!-- <p><strong>Region</strong><br><span>-</span></p> -->
                                                <!-- <p><strong>Zone</strong><br><span>-</span></p> -->
                                                <p><strong>HQ</strong><br><span>{{$employee->HqName}}</span></p>
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
                                            <div class="int-tab-peragraph" style="height: 384px;">
                                                <div class="card-header"
                                                    style="background-color:#a5cccd;border-radius:0px;">
                                                    <h5><b>Personal</b></h5>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                        <div class="profile-details">

                                                            <p><strong>DOB</strong><br>
                                                                <span>
                                                                    {{\Carbon\Carbon::parse($employee->DOB)->format('j F Y')
    
                                                                            }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Gender</strong><br>
                                                                <span>
                                                                {{ 
                                                                        $employee->Gender == 'M' 
                                                                            ? 'Male' 
                                                                            : ($employee->Gender == 'F' 
                                                                                ? 'Female' 
                                                                                : 'Not specified') 
                                                                    }}

                                                                </span>
                                                            </p>

                                                            <p><strong>Blood Group</strong><br>
                                                                <span>
                                                                    {{ 
                                                                  $employee->BloodGroup ?? ''
                                                               
                                                                    }}
        
                                                                </span>
                                                            </p>

                                                            <p><strong>Marital Status</strong><br>
                                                                <span>
                                                                {{ 
                                                                        $employee->Married == 'Y' 
                                                                            ? 'Yes' 
                                                                            : ($employee->Married == 'N' 
                                                                                ? 'No' 
                                                                                : 'Not specified') 
                                                                    }}

                                                                </span>
                                                            </p>

                                                            <p><strong>Date of Marriage</strong><br>
                                                                <span>
                                                                {{ 
                                                                   $employee->MarriageDate && $employee->MarriageDate != '0000-00-00'
                                                                    ? \Carbon\Carbon::parse($employee->MarriageDate)->format('j F')
                                                                    : '-' 
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
                                                                                $employee->MobileNo
                                                                                ??'-' 
                                                                                        }}
                                                                </span>
                                                            </p>
                                                            
                                                            <p><strong>Personal Email Id</strong><br>
                                                                <span>
                                                                    {{ $employee->EmailId_Self
                                                                    ?? '-' 
                                                                    }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Pancard No.</strong><br>
                                                                <span>
                                                                    {{ 
                                                                 $employee->PanNo
                                                                ?? '-' 
                                                                        }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Driving Licence No.</strong><br>
                                                                <span>
                                                                    {{$employee->DrivingLicNo
                                                                    ??'-' }}
                                                                </span>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                                            
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12">
                                            <div class="mfh-machine-profile">
                                                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1"
                                                    role="tablist"
                                                    style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">

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
                                                            data-bs-toggle="tab" href="#Experience" role="tab"
                                                            aria-controls="Experience" aria-selected="false">Experience</a>
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
                                                                            ucwords(strtolower($employeecontact->CurrAdd))
                                                                            ??'Not specified' 
                                                                        }},
                                                                        <br>
                                                                        City: {{ ucwords(strtolower($employeecontact->CurrentCityName))
                                                                            ?? 'Not specified' 
                                                                        }}<br>
                                                                        <!-- District: Raipur<br> -->
                                                                        State: {{ ucwords(strtolower($employeecontact->CurrentStateName))
                                                                            ?? 'Not specified' 
                                                                        }}<br>
                                                                        Pin No.: {{  $employeecontact->CurrAdd_PinNo
                                                                            ??'Not specified' 
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
                                                                                {{  $employeecontact->ParAdd??'Not specified' 
                                                                                }},<br>
                                                                                 City: {{ ucwords(strtolower($employeecontact->PermanentCityName))
                                                                                ?? 'Not specified' 
                                                                            }}<br>
                                                                                 State:{{ucwords(strtolower($employeecontact->PermanentStateName))
                                                                                ??'Not specified' 
                                                                            }}<br>Pin No.: {{$employeecontact->ParAdd_PinNo
                                                                            ?? 'Not specified' 
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
                                                                                    <td><b>Name: </b></td>
                                                                                    <td>{{ucwords(strtolower($employeecontact->Emg_Person1))
                                                                                            ?? 'Not specified' 
                                                                                    }}</td>
                                                                                </tr>

                                                                                    <tr>
                                                                                        <td><b>Number: </b></td>
                                                                                        <td>{{ $employeecontact->Emg_Contact1??'Not specified' 
                                                                                        }}</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Relation: </b></td>
                                                                                        <td>{{  ucwords(strtolower($employeecontact->Emp_Relation1))
                                                                                                ??'Not specified' 
                                                                                        }}</td>
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
                                                                                        <td><b>Name: </b></td>
                                                                                        <td>
                                                                                        {{ ucwords(strtolower($employeecontact->Emg_Person2))
                                                                                            ?? '-'
                                                                                        }}
                                                                                    </td>

                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b>Number: </b></td>
                                                                                        <td>
                                                                                            {{ $employeecontact->Emg_Contact2 
                                                                                                ??'-' 
                                                                                            }}
                                                                                        </td>

                                                                                    </tr>
                                                                                    <tr>
                                                                                    <td><b>Relation: </b></td>
                                                                                    <td>
                                                                                        {{ ucwords(strtolower($employeecontact->Emp_Relation2))
                                                                                            ?? '-'
                                                                                        }}
                                                                                    </td>
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
                                                                                <th>Occupation</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse ($allFamilyData as $data)
                                                                                <tr>
                                                                                    <td>{{ ucwords(strtolower($data->FamilyRelation ?? '-')) }}</td>
                                                                                    <td>{{ ($data->Prefix ? ucwords(strtolower($data->Prefix)) . ' ' : '') . ucwords(strtolower($data->FamilyName ?? '-')) }}</td>
                                                                                    <td>{{ $data->FamilyDOB ? \Carbon\Carbon::parse($data->FamilyDOB)->format('j F Y') : '-' }}</td>
                                                                                    <td>{{ ucwords(strtolower($data->FamilyQualification ?? '-')) }}</td>
                                                                                    <td>{{ ucwords(strtolower($data->FamilyOccupation ?? '-')) }}</td>
                                                                                </tr>
                                                                            @empty
                                                                                <tr>
                                                                                    <td colspan="5" class="text-center">No family data available.</td>
                                                                                </tr>
                                                                            @endforelse
                                                                        </tbody>
                                                                    </table>

                                                                    <!-- <div class="mt-3">
                                                                        <a class="btn-outline success-outline sm-btn" href=""
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#AddmoreFamily">Add more</a>
                                                                    </div> -->
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
                                                                            <thead class="text-center"
                                                                                style="background-color:#cfdce1;">
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
                                                                                    @foreach (['10th', '12th', 'Graduation', 'Post_Graduation'] as $qualificationType)
                                                                                        @php
                                                                                            // Find the qualification record that matches the type
                                                                                            $qualification = $qualifications->firstWhere('Qualification', $qualificationType);
                                                                                        @endphp
                                                                                        <tr>
                                                                                            <td>{{ ucwords(strtolower($qualificationType)) }}</td>
                                                                                            <td>{{ $qualification && $qualification->Specialization ? ucwords(strtolower($qualification->Specialization)) : '-' }}</td>
                                                                                            <td>{{ $qualification && $qualification->Institute ? ucwords(strtolower($qualification->Institute)) : '-' }}</td>
                                                                                            <td>{{ $qualification && $qualification->Subject ? ucwords(strtolower($qualification->Subject)) : '-' }}</td>
                                                                                            <td>{{ $qualification && $qualification->Grade_Per ? $qualification->Grade_Per : '-' }}</td>
                                                                                            <td>{{ $qualification && $qualification->PassOut ? $qualification->PassOut : '-' }}</td>
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
                                                                            <thead class="text-center"
                                                                                style="background-color:#cfdce1;">
                                                                                <tr>
                                                                                    <th>Language</th>
                                                                                    <th>Write</th>
                                                                                    <th>Read</th>
                                                                                    <th>Speak</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            @if ($languageData && $languageData->isNotEmpty())
                                                                                @foreach ($languageData as $proficiency)
                                                                                    <tr>
                                                                                        <td>{{ $proficiency->Language }}</td>
                                                                                        <td class="text-center">
                                                                                            {!! $proficiency->Write_lang === 'Y' ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            {!! $proficiency->Read_lang === 'Y' ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                                                                        </td>
                                                                                        <td class="text-center">
                                                                                            {!! $proficiency->Speak_lang === 'Y' ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>' !!}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            @else
                                                                                <tr>
                                                                                    <td colspan="4" class="text-center">No language data available.</td>
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
                                                                            <thead class="text-center"
                                                                                style="background-color:#cfdce1;">
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
                                                                                    $index = 1;
                                                                                @endphp

                                                                                @if (count($employeeExperience) > 0)
                                                                                    @foreach ($employeeExperience as $experience)
                                                                                        <tr>
                                                                                            <td>{{ $index++ }}</td>
                                                                                            <td>
                                                                                                {{
                                                                                                    $experience->ExpFromDate && $experience->ExpFromDate != '1970-01-01' && $experience->ExpFromDate != '0000-00-00'
                                                                                                        ? \Carbon\Carbon::parse($experience->ExpFromDate)->format('j F Y')
                                                                                                        : 'N/A'
                                                                                                }}
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    $experience->ExpToDate && $experience->ExpToDate != '1970-01-01' && $experience->ExpToDate != '0000-00-00'
                                                                                                        ? \Carbon\Carbon::parse($experience->ExpToDate)->format('j F Y')
                                                                                                        : 'N/A'
                                                                                                }}
                                                                                            </td>
                                                                                            <td>{{ $experience->ExpComName ?? 'N/A' }}</td>
                                                                                            <td>{{ $experience->ExpDesignation ?? 'N/A' }}</td>
                                                                                            <td>
                                                                                                @php
                                                                                                    $duration = '';
                                                                                                    if ($experience->ExpFromDate && $experience->ExpToDate && $experience->ExpFromDate != '0000-00-00' && $experience->ExpToDate != '0000-00-00') {
                                                                                                        $from = \Carbon\Carbon::parse($experience->ExpFromDate);
                                                                                                        $to = \Carbon\Carbon::parse($experience->ExpToDate);
                                                                                                        $yearsDiff = $from->diffInYears($to);
                                                                                                        
                                                                                                        // Exclude if the duration is negative or zero
                                                                                                        if ($yearsDiff > 0) {
                                                                                                            $duration = number_format($yearsDiff, 1); // Format duration to 1 decimal place
                                                                                                        } else {
                                                                                                            $duration = 'N/A'; // If negative or zero, set as N/A
                                                                                                        }
                                                                                                    } else {
                                                                                                        $duration = 'N/A'; // If dates are invalid, set as N/A
                                                                                                    }
                                                                                                @endphp
                                                                                                {{ $duration }}
                                                                                            </td>

                                                                                        </tr>
                                                                                    @endforeach
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="6" class="text-center">No experience data available.</td>
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
                                                                            <thead class="text-center"
                                                                                style="background-color:#cfdce1;">
                                                                                <tr>
                                                                                    <th>SN</th>
                                                                                    <th>Subject</th>
                                                                                    <th>Year</th>
                                                                                    <th>Date From</th>
                                                                                    <th>Date To</td>
                                                                                    <th>Day's</td>
                                                                                    <th>Location</td>
                                                                                    <th>Institute</td>
                                                                                    <th>Trainer</td>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @php
                                                                                    $index = 1;
                                                                                @endphp

                                                                                @if (count($trainingData) > 0)
                                                                                    @foreach ($trainingData as $trainingss)
                                                                                        <tr>
                                                                                            <td>{{ $index++ }}</td>
                                                                                            <td>{{ $trainingss->TraTitle ?? 'N/A' }}</td>
                                                                                            <td>{{ $trainingss->TraYear ?? 'N/A' }}</td>

                                                                                            <td>
                                                                                                {{
                                                                                                    $trainingss->TraFrom && $trainingss->TraFrom != '1970-01-01' && $trainingss->TraFrom != '0000-00-00'
                                                                                                        ? \Carbon\Carbon::parse($trainingss->TraFrom)->format('j F Y')
                                                                                                        : 'N/A'
                                                                                                }}
                                                                                            </td>
                                                                                            <td>
                                                                                                {{
                                                                                                    $trainingss->TraFrom && $trainingss->TraFrom != '1970-01-01' && $trainingss->TraFrom != '0000-00-00'
                                                                                                        ? \Carbon\Carbon::parse($trainingss->TraFrom)->format('j F Y')
                                                                                                        : 'N/A'
                                                                                                }}
                                                                                            </td>
                                                                                            <td>{{$trainingss->Duration ?? '-'}}</td>
                                                                                            <td>{{ $trainingss->Location ?? 'N/A' }}</td>
                                                                                            <td>{{ $trainingss->Institute ?? 'N/A' }}</td>
                                                                                            <td>{{ $trainingss->TrainerName ?? 'N/A' }}</td>

                                                                                        </tr>
                                                                                    @endforeach
                                                                                @else
                                                                                    <tr>
                                                                                        <td colspan="5" class="text-center">No training data available.</td>
                                                                                    </tr>
                                                                                @endif
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
                                                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">

                                                <div class="card chart-card">
                                                <div class="card-header">
                                                <h4 class="has-btn">Carrier History</h4>
                                                </div>
                                                <div class="card-body">
                                               
                                                <div style="position: relative;height:20px;">
                                                <div class="vnr-exp-box-pro"> 
                                                </div>
                                                </div>

                                                <!-- Experience Details Box -->
                                                <div class="exp-details-box">
                                                @foreach($finalResult as $index => $record)
                                                <span style="background-color: #dba62f; margin-top: -10px;" class="exp-round">&nbsp;</span>    
                                                <div class="exp-line">
                                                <!-- Display Designation -->
                                                <h5 class="mb-2 pt-3" style="color:#000;">
                                                <b>Designation:</b> {{ ucwords(strtolower($record['Current_Designation'] ?? (Auth::user()->designation->DesigName ?? 'N/A'))) }}

                                                </h5>

                                                <!-- Display Grade -->
                                                <h6>
                                                <b>Grade:</b> 
                                                @if($record['Current_Grade'] === '0')
                                                    0
                                                @else
                                                    {{ $record['Current_Grade'] ?? (Auth::user()->grade->GradeValue ?? 'N/A') }}
                                                @endif
                                                </h6>

                                                <p style="color:#9f9f9f;">
                                                Date: {{ !empty($record['SalaryChange_Date']) ? \Carbon\Carbon::parse($record['SalaryChange_Date'])->format('F Y') : 'N/A' }} |
                                                Location: {{ $hqname ?? 'N/A' }}
                                                </p>

                                                </div>
                                                @endforeach

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

        <!-- Confirmation Modal (Initially Hidden) -->
        <div class="modal" tabindex="-1" role="dialog" id="confirmationModal" style="display:none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModalBtn">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to proceed with the resignation form?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmBtn">Yes, Proceed</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Confirmation Modal (Confirm Submit) -->
        <div class="modal" tabindex="-1" role="dialog" id="submitConfirmationModal" style="display:none;">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Submit Resignation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            id="closeSubmitModalBtn">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to submit your resignation?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelSubmitBtn">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="confirmSubmitBtn">Yes, Submit</button>
                    </div>
                </div>
            </div>
        </div>
        @include('employee.footer')
