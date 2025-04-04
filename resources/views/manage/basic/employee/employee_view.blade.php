@extends('layouts.app') @section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div style="padding-top: 5px; padding-bottom: 5px;"
                    class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);"><i class="las la-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Manage</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="h-100">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body table-responsive">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <div class="">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3 profile-header">
                                                        <div class="profile-info">
                                                            <div class="profile-picture">
                                                                <img class="img-thumbnail rounded-circle"
                                                                    style="background-color: #ddd; width: 80px; height: 80px; float: left; margin-right: 15px; margin-bottom: 10px;"
                                                                    src="https://vnrseeds.co.in/AdminUser/EmpImg1Emp/{{ $employee->EmpCode }}.jpg"
                                                                    alt="Profile Picture" />
                                                            </div>
                                                            <h4 style="font-size: 16px; font-weight: 600;">
                                                                {{ $employee->employee_name }}
                                                            </h4>
                                                            <span>{{ $employee->EmailId_Vnr }}</span>
                                                            <br />
                                                            <span>{{ $employee->designation_name }},
                                                                <b>EC-{{ $employee->EmpCode }}</b></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                                        <div class="profile-details">
                                                            <p>
                                                                <strong>Function: </strong>
                                                                <span>
                                                                    {{ $employee->function }}
                                                                </span>
                                                            </p>
                                                            <p><strong>Vertical:
                                                                </strong><span>{{ $employee->vertical }}</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                                        <div class="profile-details">
                                                            <p><strong>Department:
                                                                </strong><span>{{ $employee->department }}</span></p>
                                                            <p>
                                                                <strong>Date of Joining: </strong>
                                                                <span>
                                                                    {{ \Carbon\Carbon::parse($employee->DateJoining)->format('d-m-Y') }}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                                        <div class="profile-details">
                                                            <p><strong>Grade:
                                                                </strong><span>{{ $employee->GradeValue }}</span></p>
                                                            <p><strong>Region:
                                                                </strong><span>{{ $employee->region_name }}</span></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                                        <div class="profile-details">
                                                            <p><strong>Zone:
                                                                </strong><span>{{ $employee->zone_name }}</span></p>
                                                            <p><strong>HQ:
                                                                </strong><span>{{ $employee->headquarter }}</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                        <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link active" data-tab="general">
                                                    <span class="d-block d-sm-none"><i class="ri-home-4-line"></i></span>
                                                    <span class="d-none d-sm-block">General</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="contact">
                                                    <span class="d-block d-sm-none"><i class="ri-user-line"></i></span>
                                                    <span class="d-none d-sm-block">Contact Details</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="education">
                                                    <span class="d-block d-sm-none"><i class="ri-book-line"></i></span>
                                                    <span class="d-none d-sm-block">Education</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="family">
                                                    <span class="d-block d-sm-none"><i class="ri-group-line"></i></span>
                                                    <span class="d-none d-sm-block">Family</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="language">
                                                    <span class="d-block d-sm-none"><i class="ri-translate-2"></i></span>
                                                    <span class="d-none d-sm-block">Language</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="training">
                                                    <span class="d-block d-sm-none"><i
                                                            class="ri-graduation-cap-line"></i></span>
                                                    <span class="d-none d-sm-block">Training</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="experience">
                                                    <span class="d-block d-sm-none"><i class="ri-briefcase-line"></i></span>
                                                    <span class="d-none d-sm-block">Experience</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="ctc">
                                                    <span class="d-block d-sm-none"><i
                                                            class="ri-money-dollar-box-line"></i></span>
                                                    <span class="d-none d-sm-block">CTC</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="eligibility">
                                                    <span class="d-block d-sm-none"><i
                                                            class="ri-file-list-2-line"></i></span>
                                                    <span class="d-none d-sm-block">Eligibility</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="documents">
                                                    <span class="d-block d-sm-none"><i class="ri-folder-line"></i></span>
                                                    <span class="d-none d-sm-block">Documents</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="investment">
                                                    <span class="d-block d-sm-none"><i
                                                            class="ri-bar-chart-line"></i></span>
                                                    <span class="d-none d-sm-block">Investment</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="separation">
                                                    <span class="d-block d-sm-none"><i
                                                            class="ri-user-unfollow-line"></i></span>
                                                    <span class="d-none d-sm-block">Separation</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="query">
                                                    <span class="d-block d-sm-none"><i
                                                            class="ri-question-line"></i></span>
                                                    <span class="d-none d-sm-block">Query</span>
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a href="javascript:void(0)" class="nav-link" data-tab="assets">
                                                    <span class="d-block d-sm-none"><i class="ri-safe-line"></i></span>
                                                    <span class="d-none d-sm-block">Assets</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content text-muted">
                                            <div class="tab-pane show active" data-tab="general" role="tabpanel">
                                                <div class="live-preview row">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                        <div class="card-header"
                                                            style="padding: 5px; background-color: #a5cccd; border-radius: 0px;">
                                                            <h6 class="mb-0">Personal</h6>
                                                        </div>
                                                        <ul class="plist mt-2" style="padding-left: 15px;">
                                                            <li>
                                                                <span style="font-weight: 500;">DOB:</span>
                                                                {{ \Carbon\Carbon::parse($generalInfo->DOB)->format('d F Y') }}
                                                            </li>
                                                            <li>
                                                                <span style="font-weight: 500;">Gender:</span>
                                                                {{ $generalInfo->Gender }}
                                                            </li>
                                                            <li>
                                                                <span style="font-weight: 500;">Blood Group:</span>
                                                                {{ $generalInfo->BloodGroup }}
                                                            </li>
                                                            <li>
                                                                <span style="font-weight: 500;">Marital Status:</span>
                                                                {{ $generalInfo->Married === 'Y' ? 'Yes' : 'No' }}
                                                            </li>
                                                            <li>
                                                                <span style="font-weight: 500;">Date of Marriage:</span>
                                                                @if ($generalInfo->Married === 'Y')
                                                                    {{ \Carbon\Carbon::parse($generalInfo->MarriageDate)->isValid() ? \Carbon\Carbon::parse($generalInfo->MarriageDate)->format('d F Y') : '-' }}
                                                                @endif
                                                            </li>
                                                            <li><span style="font-weight: 500;">Personal Contact
                                                                    No.:</span> {{ $generalInfo->MobileNo }}</li>
                                                            <li>
                                                                <span style="font-weight: 500;">Personal Email Id:</span>
                                                                {{ $generalInfo->EmailId_Self }}
                                                            </li>
                                                            <li>
                                                                <span style="font-weight: 500;">PAN No.:</span>
                                                                {{ $generalInfo->PanNo }}
                                                            </li>
                                                            <li>
                                                                <span style="font-weight: 500;">Driving Licence No.:</span>
                                                                {{ $generalInfo->DrivingLicNo }}
                                                            </li>
                                                            <li><span style="font-weight: 500;">Mediclaim Policy
                                                                    No.:</span> {{ $generalInfo->InsuCardNo }}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                        <div class="int-tab-peragraph">
                                                            <div class="card-header"
                                                                style="padding: 5px; background-color: #a5cccd; border-radius: 0px;">
                                                                <h6 class="mb-0">Bank</h6>
                                                            </div>
                                                            <div class="profile-details mt-2 mb-3">
                                                                <ul class="plist" style="padding-left: 15px;">
                                                                    <li>
                                                                        <span style="font-weight: 500;">Bank Name:</span>
                                                                        {{ $generalInfo->BankName }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">A/C No.:</span>
                                                                        {{ $generalInfo->AccountNo }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">Branch:</span>
                                                                        {{ $generalInfo->BranchName }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">PF No.:</span>
                                                                        {{ $generalInfo->PfAccountNo }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">PF UAN:</span>
                                                                        {{ $generalInfo->PF_UAN }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="card-header"
                                                                style="padding: 5px; background-color: #a5cccd; border-radius: 0px;">
                                                                <h6 class="mb-0">Reporting</h6>
                                                            </div>
                                                            <div class="profile-details mt-2">
                                                                <ul class="plist" style="padding-left: 15px;">
                                                                    <li>
                                                                        <span style="font-weight: 500;">Name:</span>
                                                                        {{ $generalInfo->reporting_name }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">Designation:</span>
                                                                        {{ $generalInfo->reporting_designation }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">Contact No.:</span>
                                                                        {{ $generalInfo->ReportingContactNo }}
                                                                    </li>
                                                                    <li>
                                                                        <span style="font-weight: 500;">Email Id:</span>
                                                                        {{ $generalInfo->ReportingEmailId }}
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="contact" role="tabpanel">
                                                <div class="live-preview">
                                                    <div class="row">
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="card-header">
                                                                <h5><b>Current Address</b></h5>
                                                            </div>
                                                            <div class="card-body dd-flex align-items-center">
                                                                <p>
                                                                    {{ $contactDetails->CurrAdd }}
                                                                    <br />
                                                                    City: {{ $contactDetails->curr_city }}<br />
                                                                    State: {{ $contactDetails->curr_state_name }}<br />
                                                                    Pin No.: {{ $contactDetails->CurrAdd_PinNo }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                            <div class="card-header">
                                                                <h5><b>Permanent Address</b></h5>
                                                            </div>
                                                            <div class="card-body dd-flex align-items-center">
                                                                <p>
                                                                    {{ $contactDetails->ParAdd }}<br />
                                                                    City: {{ $contactDetails->par_city }}<br />
                                                                    State:{{ $contactDetails->par_state_name }}<br />
                                                                    Pin No.: {{ $contactDetails->ParAdd_PinNo }}<br />
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
                                                                            <td>{{ $contactDetails->Emg_Person1 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Number: </b></td>
                                                                            <td>{{ $contactDetails->Emg_Contact1 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Relation: </b></td>
                                                                            <td>{{ $contactDetails->Emp_Relation1 }}</td>
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
                                                                            <td>{{ $contactDetails->Emg_Person2 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Number: </b></td>
                                                                            <td>{{ $contactDetails->Emg_Contact2 }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><b>Relation: </b></td>
                                                                            <td>{{ $contactDetails->Emp_Relation2 }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="education" role="tabpanel">
                                                <div class="live-preview">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                            <table class="table table-bordered">
                                                                <thead class="text-center"
                                                                    style="background-color: #cfdce1;">
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
                                                                    @if (count($educationDetails) > 0)
                                                                        @foreach ($educationDetails as $educationDetails)
                                                                            <tr>
                                                                                <td>{{ $educationDetails->Qualification ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $educationDetails->Specialization ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $educationDetails->Institute ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $educationDetails->Subject ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $educationDetails->Grade_Per ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $educationDetails->PassOut ?? '-' }}
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @else
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">No
                                                                                qualifications available</td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="family" role="tabpanel">
                                                <div class="live-preview">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                            <table class="table table-bordered">
                                                                <thead class="text-center" style="background-color: #cfdce1;">
                                                                    <tr>
                                                                        <th>Relation</th>
                                                                        <th>Name</th>
                                                                        <th>DOB</th>
                                                                        <th>Education</th>
                                                                        <th>Occupation</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($familyDetails->isEmpty())
                                                                        <tr>
                                                                            <td colspan="5" class="text-center">No family details available.</td>
                                                                        </tr>
                                                                    @else
                                                                        @foreach ($familyDetails as $family)
                                                                            <tr>
                                                                                <td>{{ $family['FamilyRelation'] ?? '-' }}</td>
                                                                                <td>{{ $family['FamilyName'] ?? '-' }}</td>
                                                                                <td>{{ $family['FamilyDOB'] ?? '-' }}</td>
                                                                                <td>{{ $family['FamilyQualification'] ?? '-' }}</td>
                                                                                <td>{{ $family['FamilyOccupation'] ?? '-' }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="language" role="tabpanel">
                                                <div class="live-preview">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                            <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                                <table class="table table-bordered">
                                                                    <thead class="text-center"
                                                                        style="background-color: #cfdce1;">
                                                                        <tr>
                                                                            <th>Language</th>
                                                                            <th>Write</th>
                                                                            <th>Read</th>
                                                                            <th>Speak</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @if (empty($languageDetails))
                                                                            <tr>
                                                                                <td colspan="4" class="text-center">No
                                                                                    language proficiency data available.
                                                                                </td>
                                                                            </tr>
                                                                        @else
                                                                            @foreach ($languageDetails as $lang)
                                                                                <tr>
                                                                                    <td>{{ $lang->Language ?? '-' }}</td>
                                                                                    <td class="text-center">
                                                                                        @if ($lang->Write_lang === 'Y' || $lang->Write_lang === 1 || $lang->Write_lang === true)
                                                                                            <i
                                                                                                class="bx bx-check-double text-success"></i>
                                                                                        @else
                                                                                            <i
                                                                                                class="bx bx-x text-danger"></i>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        @if ($lang->Read_lang === 'Y' || $lang->Read_lang === 1 || $lang->Read_lang === true)
                                                                                            <i
                                                                                                class="bx bx-check-double text-success"></i>
                                                                                        @else
                                                                                            <i
                                                                                                class="bx bx-x text-danger"></i>
                                                                                        @endif
                                                                                    </td>
                                                                                    <td class="text-center">
                                                                                        @if ($lang->Speak_lang === 'Y' || $lang->Speak_lang === 1 || $lang->Speak_lang === true)
                                                                                            <i
                                                                                                class="bx bx-check-double text-success"></i>
                                                                                        @else
                                                                                            <i
                                                                                                class="bx bx-x text-danger"></i>
                                                                                        @endif
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="training" role="tabpanel">
                                                <div class="live-preview">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                            <table class="table table-bordered">
                                                                <thead class="text-center"
                                                                    style="background-color: #cfdce1;">
                                                                    <tr>
                                                                        <th>SN</th>
                                                                        <th>Subject</th>
                                                                        <th>Year</th>
                                                                        <th>Date From</th>
                                                                        <th>Date To</th>
                                                                        <th>Day's</th>
                                                                        <th>Location</th>
                                                                        <th>Institute</th>
                                                                        <th>Trainer</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if (empty($trainingDetails) || count($trainingDetails) === 0)
                                                                        <tr>
                                                                            <td colspan="9" class="text-center">No
                                                                                training details available.</td>
                                                                        </tr>
                                                                    @else
                                                                        @foreach ($trainingDetails as $index => $training)
                                                                            <tr>
                                                                                <td>{{ $index + 1 }}</td>
                                                                                <td>{{ $training->TraName ?? '-' }}</td>
                                                                                <td>{{ \Carbon\Carbon::parse($training->TraDate)->format('Y') ?? '-' }}
                                                                                </td>
                                                                                <td>{{ \Carbon\Carbon::parse($training->FromDate)->format('j F Y') ?? '-' }}
                                                                                </td>
                                                                                <td>{{ \Carbon\Carbon::parse($training->ToDate)->format('j F Y') ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $training->TraDuration ?? '-' }}
                                                                                </td>
                                                                                <td>{{ $training->Location ?? '-' }}</td>
                                                                                <td>{{ $training->Institute ?? '-' }}</td>
                                                                                <td>{{ $training->Trainer ?? '-' }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="experience" role="tabpanel">
                                                <div class="live-preview">
                                                    <div class="row">
                                                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                                                            <table class="table table-bordered">
                                                                <thead class="text-center"
                                                                    style="background-color: #cfdce1;">
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
                                                                    @if (empty($experienceDetails) || $experienceDetails->isEmpty())
                                                                        <tr>
                                                                            <td colspan="6" class="text-center">No
                                                                                experience details available.</td>
                                                                        </tr>
                                                                    @else
                                                                        @foreach ($experienceDetails as $index => $experience)
                                                                            <tr>
                                                                                <td>{{ $index + 1 }}</td>
                                                                                <td>{{ date('d F Y', strtotime($experience->ExpFromDate)) }}
                                                                                </td>
                                                                                <td>{{ date('d F Y', strtotime($experience->ExpToDate)) }}
                                                                                </td>
                                                                                <td>{{ $experience->ExpComName }}</td>
                                                                                <td>{{ $experience->ExpDesignation }}</td>
                                                                                <td>{{ $experience->ExpTotalYear }} Yrs
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="ctc" role="tabpanel">
                                                <div class="live-preview row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card chart-card">
                                                            <div class="card-header">
                                                                <h5 class="has-btn"><b>Monthly Components</b></h5>
                                                            </div>
                                                            <div class="card-body dd-flex align-items-center">
                                                                <ul class="ctc-section" id="monthly-components">
                                                                    <li>
                                                                        <div class="ctc-title">Basic</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="BAS_Value">
                                                                                @if ($ctcDetails->BAS_Value != '' && $ctcDetails->BAS_Value != null )
                                                                                {{ rtrim(rtrim(number_format($ctcDetails->BAS_Value, 2), '0'), '.') }}
                                                                                @else
                                                                                    
                                                                                @endif
                                                                            </b>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">HRA</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="HRA_Value">{{ rtrim(rtrim(number_format($ctcDetails->HRA_Value, 2), '0'), '.') }}</b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Bonus <sup>1</sup></div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="Bonus1_Value">{{ rtrim(rtrim(number_format($ctcDetails->BAS_Value, 2), '0'), '.') }}</b>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Special Allowance</div>
                                                                        <div class="ctc-value">
                                                                            <i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="SpecialAllowance_Value">
                                                                                {{ rtrim(rtrim(number_format($ctcDetails->SPECIAL_ALL_Value, 2), '0'), '.') }}
                                                                            </b>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Gross Monthly Salary</div>
                                                                        <div class="ctc-value">
                                                                            <i class="bx bx-rupee"></i> <b class="ml-2"
                                                                                id="Gross_Monthly_Salary">{{ rtrim(rtrim(number_format($ctcDetails->Tot_GrossMonth, 2), '0'), '.') }}</b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">DA</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="DA"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrears</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arreares"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Leave Encash</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="LeaveEncash"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Car Allowance</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Car_Allowance"></b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Incentive</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Incentive"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Variable Reimbursement</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="VarRemburmnt"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Variable Adjustment</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="VariableAdjustment"></b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">City Compensatory Allowance
                                                                            (CCA)</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="CCA"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Relocation Allowance</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="RA"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Basic</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Basic"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear HRA</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Hra"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Special Allowance
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Spl"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Conveyance</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Conv"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">CEA</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="YCea"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">MR</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="YMr"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">LTA</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="YLta"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Car Allowance</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Car_Allowance_Arr"></b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Leave Encash</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_LvEnCash"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Bonus</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Bonus"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear LTA Reimbursement
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_LTARemb"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Relocation Allowance
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_RA"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear Performance Pay</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_PP"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Bonus Adjustment</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Bonus_Adjustment"></b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Performance Incentive</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="PP_Inc"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">National Pension Scheme
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="NPS"></b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Provident Fund</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="Tot_Pf_Employee">{{ rtrim(rtrim(number_format($ctcDetails->BAS_Value, 2), '0'), '.') }}</b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">TDS</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="TDS"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">ESIC</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="ESCI_Employee"></b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">NPS Contribution</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="NPS_Value"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear PF</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Pf"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Arrear ESIC</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="Arr_Esic"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Voluntary Contribution</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="VolContrib"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Deduct Adjustment</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="DeductAdjmt"></b></div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Recovery Special Allowance
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2" id="RecSplAllow"></b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title"
                                                                            style="font-weight: 600; font-size: 14px;">
                                                                            Net Monthly Salary
                                                                        </div>
                                                                        <div class="ctc-value"
                                                                            style="font-weight: 600; font-size: 15px;">
                                                                            <i class="bx bx-rupee"></i> <b class="ml-2"
                                                                                id="Net_Monthly_Salary">{{ rtrim(rtrim(number_format($ctcDetails->BAS_Value, 2), '0'), '.') }}</b>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card">
                                                            <div class="card-header ctc-head-title">
                                                                <h5 class="has-btn"><b>Annual Components</b></h5>
                                                                <p class="mb-0">(Tax saving components which shall be
                                                                    reimbursed on production of documents)</p>
                                                            </div>
                                                            <div class="card-body dd-flex align-items-center">
                                                                <ul class="ctc-section" id="annual-components">
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Leave Travel Allowance</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="LTA_Value">{{ rtrim(rtrim(number_format($ctcDetails->BAS_Value, 2), '0'), '.') }}</b>
                                                                        </div>
                                                                    </li>
                                                                    <li style="display: none;">
                                                                        <div class="ctc-title">Children Education Allowance
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="ChildEduAllowance_Value">2,400</b>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title"
                                                                            style="font-weight: 600; font-size: 14px;">
                                                                            Annual Gross Salary
                                                                        </div>
                                                                        <div class="ctc-value"
                                                                            style="font-weight: 600; font-size: 15px;"><i
                                                                                class="bx bx-rupee"></i> <b class="ml-2"
                                                                                id="AnnualGrossSalary_Value">678024</b>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card">
                                                            <div class="card-header ctc-head-title">
                                                                <h5 class="has-btn"><b>Other Annual Components</b></h5>
                                                                <p class="mb-0">(Statutory Components)</p>
                                                            </div>
                                                            <div class="card-body dd-flex align-items-center">
                                                                <ul class="ctc-section" id="other-annual-components">
                                                                    <li>
                                                                        <div class="ctc-title">
                                                                            Estimated Gratuity
                                                                            <sup>2</sup>
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="Gratuity_Value">16299</b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Employer's PF Contribution
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="EmployerPF_Value">40680</b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Mediclaim Policy Premiums
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="MediclaimPolicy_Value">15000</b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Fixed CTC</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="FixedCTC_Value">750003</b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title">Performance Pay</div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="PerformancePay_Value">33901</b></div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="ctc-title"
                                                                            style="font-weight: 600; font-size: 14px;">
                                                                            Total CTC
                                                                        </div>
                                                                        <div class="ctc-value"
                                                                            style="font-weight: 600; font-size: 15px;"><i
                                                                                class="bx bx-rupee"></i> <b class="ml-2"
                                                                                id="TotalCTC_Value">783904</b></div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card">
                                                            <div class="card-header">
                                                                <h5 class="has-btn"><b>Additional Benefit</b></h5>
                                                            </div>
                                                            <div class="card-body dd-flex align-items-center">
                                                                <ul class="ctc-section" id="additional-benefit">
                                                                    <li>
                                                                        <div class="ctc-title">Insurance Policy Premium
                                                                        </div>
                                                                        <div class="ctc-value"><i class="bx bx-rupee"></i>
                                                                            <b class="ml-2"
                                                                                id="InsurancePremium_Value">200000</b>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="eligibility" role="tabpanel">
                                                <div class="live-preview row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <div class="card chart-card">
                                                            <div class="card-header eligibility-head-title">
                                                                <h5 class="has-btn"><b>Lodging Entitlements</b></h5>
                                                                <p class="mb-0">(Actual with upper limits per day)</p>
                                                            </div>
                                                            <div class="card-body align-items-center">
                                                                <ul class="eligibility-list">
                                                                    <li>
                                                                        City Category A: <span
                                                                            class="p-0">/-</span><span
                                                                            id="lodgingA">2000</span><span><i
                                                                                class="bx bx-rupee"></i></span>
                                                                    </li>
                                                                    <li>
                                                                        City Category B: <span
                                                                            class="p-0">/-</span><span
                                                                            id="lodgingB">1800</span><span><i
                                                                                class="bx bx-rupee"></i></span>
                                                                    </li>
                                                                    <li>
                                                                        City Category C: <span
                                                                            class="p-0">/-</span><span
                                                                            id="lodgingC">1500</span><span><i
                                                                                class="bx bx-rupee"></i></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card">
                                                            <div class="card-header ctc-head-title">
                                                                <h5 class="has-btn"><b>Travel Eligibility</b></h5>
                                                                <p class="mb-0">(For Official Purpose Only)</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="eligibility-list">
                                                                    <li id="twheelerSection">
                                                                        <strong>2 Wheeler:</strong>
                                                                        <span id="twheeler">
                                                                            <p>3.5 /Km (Approval based for official use)</p>
                                                                        </span>
                                                                    </li>
                                                                    <li style="display: none;"><strong>4 Wheeler:</strong>
                                                                        <span id="fwheeler"></span></li>
                                                                    <li id="classoutside" style="display: none;">
                                                                        <strong>Mode/Class outside HQ:</strong> <span
                                                                            id="outsideHq"></span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card" id="mobileeligibility">
                                                            <div class="card-header eligibility-head-title">
                                                                <h5 class="has-btn"><b>Mobile Eligibility</b></h5>
                                                                <p class="mb-0">(Subject to submission of bills)</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="eligibility-list">
                                                                    <li>Mobile Handset Eligibility: <span
                                                                            id="handset"></span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card">
                                                            <div class="card-header eligibility-head-title">
                                                                <h5 class="has-btn"><b>Daily Allowances</b></h5>
                                                                <p class="mb-0"></p>
                                                            </div>
                                                            <div class="card-body align-items-center">
                                                                <ul class="eligibility-list">
                                                                    <li id="daHqsection" style="display: none;">DA@HQ:
                                                                        <span id="daHq"></span> <span>/- Per
                                                                            Day</span></li>
                                                                    <li>DA Outside HQ: <span id="daOutsideHq">Upto
                                                                            Rs.450/day (With Bills)</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card chart-card">
                                                            <div class="card-header eligibility-head-title">
                                                                <h5 class="has-btn"><b>Insurance</b></h5>
                                                                <p class="mb-0">(Sum Insured)</p>
                                                            </div>
                                                            <div class="card-body">
                                                                <ul class="eligibility-list">
                                                                    <li>
                                                                        <strong>Health Insurance:</strong><span
                                                                            id="health_ins">2 Lakhs</span><span><i
                                                                                class="bx bx-rupee"></i></span>
                                                                    </li>
                                                                    <li>
                                                                        <strong>Group Term Life Insurance:</strong><span
                                                                            id="group_term">10 Lakhs</span><span><i
                                                                                class="bx bx-rupee"></i></span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="documents" role="tabpanel">
                                                <div class="live-preview row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <h6><b>Importamt Documents</b></h6>
                                                        <table class="table table-bordered">
                                                            <thead class="text-center" style="background-color: #cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Documents name</th>
                                                                    <th>Verify</th>
                                                                    <th>View</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>Adhar Card</td>
                                                                    <td class="text-center"><i
                                                                            class="ri-checkbox-circle-line text-success"></i>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>Driving Licence</td>
                                                                    <td class="text-center"><i
                                                                            class="ri-checkbox-circle-line text-success"></i>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3.</td>
                                                                    <td>Passport</td>
                                                                    <td class="text-center"><i
                                                                            class="ri-close-circle-line text-danger"></i>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4.</td>
                                                                    <td>Pan Card</td>
                                                                    <td class="text-center"><i
                                                                            class="ri-close-circle-line text-danger"></i>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <h6><b>Health Card</b></h6>
                                                        <table class="table table-bordered">
                                                            <thead class="text-center" style="background-color: #cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Documents name</th>
                                                                    <th>Documents type</th>
                                                                    <th>View</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>Health Card</td>
                                                                    <td>Self</td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>Health Card</td>
                                                                    <td>Spouse</td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h6><b>TDS Cert. 2024-2025 </b></h6>
                                                        <table class="table table-bordered">
                                                            <thead class="text-center" style="background-color: #cfdce1;">
                                                                <tr>
                                                                    <th>SN</th>
                                                                    <th>Documents name</th>
                                                                    <th>View</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>1.</td>
                                                                    <td>Form A</td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2.</td>
                                                                    <td>Form B</td>
                                                                    <td class="text-center">
                                                                        <a title="view" href=""><i
                                                                                class="ri-eye-fill text-success me-2"></i></a>
                                                                        | <a title="Download" href=""><i
                                                                                class="ms-2 ri-download-line text-success"></i></a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="investment" role="tabpanel">
                                                <div class="live-preview">
                                                    <table class="table table-bordered">
                                                        <thead class="text-center" style="background-color: #cfdce1;">
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Year</th>
                                                                <th>Declaration Date</th>
                                                                <th>Sumitted Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1.</td>
                                                                <td>2023</td>
                                                                <td>31-01-2023</td>
                                                                <td>10-02-2023</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="separation" role="tabpanel">
                                                <div class="live-preview">
                                                    <table class="table table-bordered">
                                                        <thead class="text-center" style="background-color: #cfdce1;">
                                                            <tr>
                                                                <th>SN</th>
                                                                <th>Date of Joining</th>
                                                                <th>Confirmation Date</th>
                                                                <th>Resignation Date</th>
                                                                <th>Relieving Date</th>
                                                                <th>Resignation Reason</th>
                                                                <th>Relieving Date by Reporting/HOD</th>
                                                                <th>Reporting Remark</th>
                                                                <th>Details</th>
                                                                <th>Reporting Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1.</td>
                                                                <td>12 July 2021</td>
                                                                <td>30 Jan 2022</td>
                                                                <td>2 February 2024</td>
                                                                <td>10 April 2024</td>
                                                                <td>Better Opportunity</td>
                                                                <td>20 July 2024</td>
                                                                <td>ok done</td>
                                                                <td>view</td>
                                                                <td class="text-success">Done</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="tab-pane" data-tab="query" role="tabpanel"></div>

                                            <div class="tab-pane" data-tab="assets" role="tabpanel">
                                                <h6>Official Assets</h6>
                                                <table id="myTable" class="table table-bordered">
                                                    <thead class="text-center" style="background-color: #cfdce1;">
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Type of Asset</th>
                                                            <th>Company</th>
                                                            <th>Model Name</th>
                                                            <th>Allocated Date</th>
                                                            <th>Returned Date</th>
                                                            <th>Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (empty($assetsDetails) || $assetsDetails->isEmpty())
                                                            <tr>
                                                                <td colspan="7" class="text-center">No asset details available.</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($assetsDetails as $index => $asset)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $asset->AssetName ?? '-' }}</td>
                                                                    <td>{{ $asset->AComName ?? '-' }}</td>
                                                                    <td>{{ $asset->AModelName ?? '-' }}</td>
                                                                    <td>
                                                                        {{ $asset->AAllocate ? \Carbon\Carbon::parse($asset->AAllocate)->format('d-m-Y') : '-' }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $asset->ADeAllocate ? \Carbon\Carbon::parse($asset->ADeAllocate)->format('d-m-Y') : '-' }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="#" class="btn btn-sm btn-primary">View</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                
                                                

                                                <h6>Assets Request</h6>
                                                <table class="table table-bordered">
                                                    <thead class="text-center" style="background-color: #cfdce1;">
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Type of Asset</th>
                                                            <th>Company</th>
                                                            <th>Model Name</th>
                                                            <th>Request Date</th>
                                                            <th>Details</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (empty($assetsRequestDetails) || $assetsRequestDetails->isEmpty())
                                                            <tr>
                                                                <td colspan="6" class="text-center">No asset requests found.</td>
                                                            </tr>
                                                        @else
                                                            @foreach ($assetsRequestDetails as $index => $asset)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $asset->AssetName ?? '-' }}</td>
                                                                    <td>{{ $asset->ComName ?? '-' }}</td>
                                                                    <td>{{ $asset->ModelName ?? '-' }}</td>
                                                                    <td>
                                                                        {{ $asset->ReqDate ? \Carbon\Carbon::parse($asset->ReqDate)->format('d-m-Y') : '-' }}
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="#" class="btn btn-sm btn-primary">View</a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
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
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navLinks = document.querySelectorAll(".nav-link");
            const tabPanes = document.querySelectorAll(".tab-pane");
            navLinks.forEach(function(tab) {
                tab.addEventListener("click", function(e) {
                    e.preventDefault();
                    navLinks.forEach(function(nav) {
                        nav.classList.remove("active");
                    });
                    tabPanes.forEach(function(pane) {
                        pane.classList.remove("show", "active");
                    });
                    const tabKey = tab.getAttribute("data-tab");
                    tab.classList.add("active");
                    document.querySelector(`.tab-pane[data-tab="${tabKey}"]`).classList.add("show",
                        "active");
                });
            });
        });
    </script>
@endsection
