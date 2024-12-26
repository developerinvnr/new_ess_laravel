@include('seperation.head')
@include('seperation.header');
@include('seperation.sidebar');


<body class="mini-sidebar">
    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('seperation.head')
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
                                                <!-- <img src="{{ asset('employeeimages/' . Auth::user()->employeephoto->EmpPhotoPath) }}"
                                                    alt="Profile Picture"> -->
                                                <img src="https://vnrseeds.co.in/AdminUser/EmpImg1Emp/{{Auth::user()->EmpCode}}.jpg"
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
       
        <script>

$(document).ready(function() {
    var employeeId = {{ Auth::user()->EmployeeID }}; // Assuming you're using Blade syntax to inject the employee ID

    // Make an AJAX call to the controller method to fetch the Relieving Date and other details
    $.ajax({
        url: '{{ url("/employee/calculate-relieving-date") }}', // The route URL
        type: 'POST',
        data: {
            EmployeeId: employeeId,  // Send the EmployeeID to the controller
            _token: '{{ csrf_token() }}' // Add CSRF token
        },
        success: function(response) {
            // On success, update the form fields with the fetched data
            if (response.Emp_ResignationDate) {
                $('#ResDate').val(response.Emp_ResignationDate);  // Set the resignation date
                $('#ResDate').prop('readonly', true);  // Make it readonly
                $('#ResDateSpan').html("<strong>Resignation Date:  </strong>" + response.Emp_ResignationDate).show(); // Display as span
            } else {
                $('#ResDate').show(); // Otherwise, show the input field
            }

            if (response.Emp_RelievingDate) {
                $('#RelDate').val(response.Emp_RelievingDate);  // Set the relieving date
                $('#RelDate').prop('readonly', true);  // Make it readonly
                $('#RelDateSpan').html("<strong>Expected Relieving Date (By Employee):  </strong>" + response.Emp_RelievingDate).show(); // Display as span

            } else {
                $('#RelDate').show(); // Otherwise, show the input field
            }

            if (response.Emp_Reason) {
                $('#Reason').val(response.Emp_Reason);  // Set the reason
                $('#Reason').prop('readonly', true);  // Make it readonly
                $('#ReasonSpan').html("<strong>Reason:  </strong>" + response.Emp_Reason).show(); // Display as span with bold text
            } else {
                $('#Reason').show(); // Otherwise, show the input field
            }

            // Show the file preview section if the file exists
            if (response.SprUploadFile) {
                // Show the preview link
                $('#previewLink').show();
                $('#SCopy').prop('disabled', true); // Disable the file input field

                // Set the file path using asset() function
                var fileExtension = response.SprUploadFile.split('.').pop().toLowerCase();
                var filePath = "{{ asset('uploads/resignation_letters/') }}" + '/' + response.SprUploadFile;

                // Toggle preview on click of the "Preview Resignation" link
                $('#previewLink').click(function() {
                    // Toggle visibility of the preview section
                    $('#filePreviewSection').toggle();

                    // If the section is visible, check the file type and display the preview
                    if ($('#filePreviewSection').is(":visible")) {
                        // If the file is an image
                        if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png') {
                            $('#filePreviewContainer').html('<img src="' + filePath + '" alt="Resignation Letter" class="img-fluid">');
                        }
                        // If the file is a PDF
                        else if (fileExtension === 'pdf') {
                            $('#filePreviewContainer').html('<iframe src="' + filePath + '" width="100%" height="400px"></iframe>');
                        }
                    } else {
                        // If the section is hidden, clear the preview content
                        $('#filePreviewContainer').html('');
                    }
                });
            } else {
                // If no file, hide the preview section and link
                $('#previewLink').hide();
                $('#filePreviewSection').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + " " + error);  // Handle errors
        }
    });
});


//              // This function will be called on page load
//  $(document).ready(function() {
//     var employeeId = {{ Auth::user()->EmployeeID }};
//     const token = $('input[name="_token"]').val();

//    // Make an AJAX call to the controller method to fetch the Relieving Date
//    $.ajax({
//     url: '{{ url("/employee/calculate-relieving-date") }}', // The route URL
//     type: 'POST',
//        data: {
//            EmployeeId: employeeId,  // Send the EmployeeID to the controller
//        },
//        headers: {
//                 'X-CSRF-TOKEN': token // Send CSRF token in the request header
//             },
//        success: function(response) {
//            // On success, update the Relieving Date field with the fetched value
//            if (response.RelDate) {
//                $('#RelDate').val(response.RelDate);  // Set the calculated relieving date
//            }
//        },
//        error: function(xhr, status, error) {
//            console.error("AJAX Error: " + status + " " + error);  // Handle errors
//        }
//    });
// });
        </script>
        <script src="{{ asset('../js/dynamicjs/profile.js/') }}" defer></script>
