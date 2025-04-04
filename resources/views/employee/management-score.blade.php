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
                           <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                        </li>
                        <li class="breadcrumb-link active">PMS - Management </li>
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
                     <a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{ route('pmsinfo') }}" role="tab" aria-selected="true">
                     <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                     <span class="d-none d-sm-block">PMS Information</span>
                     </a>
                  </li>
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;"  class="nav-link"  href="{{route('pms')}}" role="tab" aria-selected="true">
                     <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                     <span class="d-none d-sm-block">Employee</span>
                     </a>
                  </li>
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{ route('appraiser') }}" role="tab" aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">Appraiser</span>
                     </a>
                  </li>
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('reviewer')}}" role="tab" aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">Reviewer</span>
                     </a>
                  </li>
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link" href="{{route('hod')}}" role="tab" aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">HOD</span>
                     </a>
                  </li>
                  <li class="nav-item" role="presentation">
                     <a style="color: #0e0e0e;min-width:105px;" class="nav-link active" href="{{route('management')}}" role="tab" aria-selected="false" tabindex="-1">
                     <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                     <span class="d-none d-sm-block">Management</span>
                     </a>
                  </li>
               </ul>
            </div>
            <!-- Revanue Status Start -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3">
               <div class="mfh-machine-profile">
                  <ul class="nav nav-tabs bg-light mb-3" id="myTab1" role="tablist" >
                     <li class="nav-item">
                        <a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 " id="profile-tab20"  href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA 2024</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4" id="profile-tab20" href="{{route('management')}}#KraTab" role="tab" aria-controls="KraTab" aria-selected="false">My Team KRA New 2025-26</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;" class="nav-link pt-4 active" id="team_appraisal_tab20" data-bs-toggle="tab" href="#teamappraisal" role="tab" aria-controls="teamappraisal" aria-selected="false">Team Appraisal</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: #0e0e0e;padding-top:10px !important;border-right: 1px solid #ddd;min-width:115px;" class="nav-link pt-4 text-center" id="team_report_tab20"  href="{{route('managementReport')}}" role="tab" aria-controls="teamreport" aria-selected="false">Report</a>
                     </li>
                     <li class="nav-item">
                        <a style="color: #0e0e0e;padding-top:10px !important;min-width:115px;" class="nav-link pt-4 text-center" id="team_graph_tab20" href="{{route('managementGraph')}}" role="tab" aria-controls="teamgraph" aria-selected="false">Graph</a>
                     </li>
                  </ul>
                  <div class="tab-content ad-content2" id="myTabContent2">
                     <div class="tab-pane fade active show" id="teamappraisal" role="tabpanel">
                        <div class="row">
                           <div class="mfh-machine-profile">
                              <div style="margin-top:-40px;float:left;margin-left:660px;">
                                 <ul class="kra-btns nav nav-tabs border-0" id="myTab1" role="tablist">
                                    <li class="mt-1"><a class="active" id="home-tab1" style="margin-left: 38px;font-size: 15px;"
                                       data-bs-toggle="tab" href="#Score" role="tab"
                                       aria-controls="home" aria-selected="true">Score <i
                                       class="fas fa-star mr-2"></i></a></li>
                                    <li class="mt-1"><a class="" id="Promotion-tab20"
                                       href="{{route('managementPromotion')}}" role="tab" style="font-size: 15px;"
                                       aria-controls="Promotion" aria-selected="false">Promotion
                                       <i class="fas fa-file-alt mr-2"></i></a>
                                    </li>
                                    <li class="mt-1"><a class="" id="Increment-tab21"
                                       href="{{route('managementIncrement')}}" role="tab" style="font-size: 15px;"
                                       aria-controls="Increment" aria-selected="false">Increment <i class="fas fa-file-invoice mr-2"></i></a></li>
                                 </ul>
                              </div>
                              <div class="tab-content splash-content2" id="myTabContent2">
                                 <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
                                    id="Score" role="tabpanel" >
                                    <div class="card">
                                       <div class="card-header" style="background-color:#A8D0D2;">
                                          <b>Team Score</b>
                                          <div class="float-end">

                                             <select id="department-filter">
                                                <option value="">All Departments</option>
                                                @foreach($employeeDetails->unique('department_name') as $employee)
                                                <option value="{{ $employee->department_name }}">{{ $employee->department_name }}</option>
                                                @endforeach
                                             </select>
                                             <select id="grade-filter">
                                                <option value="">All Grade</option>
                                                @foreach($employeeDetails->unique('grade_name') as $grade)
                                                <option value="{{ $grade->grade_name }}">{{ $grade->grade_name }}</option>
                                                @endforeach
                                             </select>
                                          
                                             <select id="state-filter">
                                                <option value="">All State</option>
                                                @foreach($employeeDetails->unique('city_village_name') as $hq)
                                                <option value="{{ $hq->city_village_name }}">{{ $hq->city_village_name }}</option>
                                                @endforeach
                                             </select>
                                     
                                             <select id="region-filter" style="display:none;">
                                                      <option value="">All Region</option>
                                                      @foreach($employeeDetails->unique('region_name') as $reg)
                                                            <option value="{{ $reg->region_name }}">{{ $reg->region_name }}</option>
                                                      @endforeach
                                             </select>
                                               
                                           
                                             <a title="Logic" data-bs-toggle="modal" data-bs-target="#logicpopup">Logic <i class="fas fa-tasks mr-2 ms-2"></i></a>
                                             Export:
                                             <a title="Excel" href=""> <i class="fas fa-file-excel mr-2 ms-2"></i></a> |
                                             <a title="PDF" href=""><i class="fas fa-file-pdf mr-2 ms-2"></i></a>
                                          </div>
                                          <a class="effect-btn btn btn-success squer-btn sm-btn float-end">Final Submit <i class="fas fa-check-circle mr-2"></i></a>
                                       </div>
                                       <div id="scorelist" class="card-body table-responsive dd-flex align-items-center" style="max-height: 500px; overflow-y: auto;">
                                          <table class="table table-pad" id="employeetablemang">
                                             <thead>
                                                <tr>
                                                   <th rowspan="2" class="text-center" style="border-right:1px solid #fff;">SN.</th>
                                                   <th colspan="4" class="text-center" style="border-right:1px solid #fff;">Employee Information</th>
                                                   <th colspan="8" class="text-center" style="border-right:1px solid #fff;">Score/Rating</th>
                                                   <th rowspan="3" class="text-center">History</th>
                                                   <th rowspan="3" class="text-center">Action</th>
                                                </tr>
                                                <tr>
                                                   <th class="text-center">EC</th>
                                                   <th class="text-center">Name</th>
                                                   <th class="text-center">Department</th>
                                                   <th id="sortGrade" class="text-center" style="cursor: pointer;">Grade ⬍</th>
                                                   <th class="text-center">Last Rating</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;">Appraiser</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;">Reviewer/HOD</th>
                                                   <th class="text-center" style="border-right: 1px solid #fff;">Details</th>
                                                   <th colspan="4" class="text-center" style="border-right: 1px solid #fff;">Management</th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                @foreach($employeeDetails as $employeedetails)
                                                <tr>
                                                   <td>{{ $loop->iteration }}</td>
                                                   <td class="text-center">{{$employeedetails->EmpCode}}</td>
                                                   <td>{{ $employeedetails->Fname }} {{ $employeedetails->Sname }} {{ $employeedetails->Lname }}</td>
                                                   <td class="text-center">{{$employeedetails->department_name}}</td>
                                                   <td class="text-center">{{$employeedetails->grade_name}}</td>
                                                   
                                                   <td class="hidden-state d-none">{{ $employeedetails->city_village_name }}</td>
                                                   <td class="hidden-reg d-none">{{ $employeedetails->region_name }}</td>


                                                   <td class="text-center">{{$employeedetails->FirstRating ?? '-'}}</td>
                                                   <td class="text-center"><span class="r-color">{{$employeedetails->Emp_TotalFinalScore}}</span>/<span class="p-color">{{$employeedetails->Emp_TotalFinalRating}}</span></td>
                                                   <td class="text-center r-color"><span class="r-color">{{$employeedetails->Appraiser_TotalFinalScore}}</span>/<span class="p-color">{{$employeedetails->Appraiser_TotalFinalRating}}</span></td>
                                                   <td class="text-center r-color"><span class="r-color">{{$employeedetails->Reviewer_TotalFinalScore}}</span>/<span class="p-color">{{$employeedetails->Reviewer_TotalFinalRating}}</span></td>
                                                  
                                                   <td class="text-center"><a title="History" data-bs-toggle="modal" onclick="showEmployeeDetails({{ $employeedetails->EmployeeID }})" 
                                                      data-companyid="{{ $employeedetails->CompanyId }}" ><i class="fas fa-eye"></i></a></td>
                                                   <td>
                                                      <input class="form-control score-input"  data-employeeid="{{$employeedetails->EmployeeID}}" 
                                                      type="number" name="score" style="width:70px;" readonly value="{{ $employeedetails->Hod_TotalFinalScore }}"/>
                                                   </td>
                                                   <td>
                                                      <input class="form-control" id="rating-input{{$employeedetails->EmployeeID}}"type="number" style="width:70px;" 
                                                         value="{{ $employeedetails->Hod_TotalFinalRating }}" readonly />
                                                   </td>
                                                   <td><input style="width:114px;" class="form-control remarks-input" name="remark" data-employeeid="{{ $employeedetails->EmployeeID }}"
                                                   value="{{$employeedetails->HodRemark}}"  readonly placeholder="Enter your remarks"></input></td>

                                                   <td>
                                                      <a href="#" data-bs-toggle="modal" data-bs-target="#viewEmpdetails-{{ $employeedetails->EmployeeID }}">
                                                      <i class="fas fa-eye mr-2"></i>
                                                      </a>
                                                   </td>
                                                   <td>
                                                   <a title="Edit" href="#" class="edit-score" data-employeeid="{{ $employeedetails->EmployeeID }}">
                                                            <i class="fas fa-edit"></i>
                                                         </a>
												                  <a title="Save" href="javascript:void(0);" style="display:none;" class="save-btn" data-employeeid="{{$employeedetails->EmployeeID}}"
                                                      data-pmsid="{{$PmsYId}}" data-companyid="{{$employeedetails->CompanyId}}">
                                                      <i style="font-size:14px;" class="ri-save-3-line text-success mr-2"></i>
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
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @include('employee.footerbottom')
         </div>
      </div>
   </div>
   <!-- Employee Details Modal -->
   <div class="modal fade" id="empdetails" data-bs-backdrop="static"tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <img id="employeeImage" src="" alt="Employee Image" class="rounded-circle me-2" width="40" height="40">
                  <span id="employeeName"></span>
               </h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row emp-details-sep">
                  <div class="col-md-6">
                     <ul>
                        <li><b>Employee Code:</b> <span id="employeeCode"></span></li>
                        <li><b>Designation:</b> <span id="designation"></span></li>
                        <li><b>Total VNR Experience:</b> <span id="totalExperienceYears"></span></li>
                     </ul>
                  </div>
                  <div class="col-md-6">
                     <ul>
                        <li><b>Date of Joining:</b> <span id="dateJoining"></span></li>
                        <li><b>Prev Experience:</b> <span id="totalprevExperienceYears"></span></li>
                     </ul>
                  </div>
                  <div class="col-md-12 mt-3">
                     <h5 id="careerh5"><b>Carrier Progression in VNR</b></h5>
                     <table class="table table-bordered mt-2">
                        <thead style="background-color:#cfdce1;">
                           <tr>
                              <th>SN</th>
                              <th>Date</th>
                              <th>Grade</th>
                              <th>Designation</th>
                              <th>Monthly Gross</th>
                              <th>CTC</th>
                              <th>Rating</th>
                           </tr>
                        </thead>
                        <tbody id="careerProgressionTable">
                           <!-- Career progression data will be populated here dynamically -->
                        </tbody>
                     </table>
                  </div>
                  <div class="col-md-12 mt-3" id="careerprev">
                     <h5 ><b>Previous Employers</b></h5>
                     <table class="table table-bordered mt-2">
                        <thead style="background-color:#cfdce1;">
                           <tr>
                              <th>SN</th>
                              <th>Company</th>
                              <th>Designation</th>
                              <th>From Date</th>
                              <th>To Date</th>
                              <th>Duration</th>
                           </tr>
                        </thead>
                        <tbody id="experienceTable">
                           <!-- Experience data will be populated here dynamically -->
                        </tbody>
                     </table>
                  </div>
                  <!-- Developmental Progress -->
                  <div class="col-md-12 mt-3" id="careerprev">
                     <h5 class="float-start"><b>Developmental Progress</b></h5>
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
                        <tbody id="trainingProgramsTable">
                           <tr>
                              <td colspan="7" class="text-center">Loading...</td>
                           </tr>
                        </tbody>
                     </table>
                     <h5 class="mb-2">B. Conference Attended</h5>
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
                        <tbody id="conferenceTable">
                           <tr>
                              <td colspan="6" class="text-center">Loading...</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!------- emp details for managements ------->
   @foreach ($employeeDetails as $employee)
<div class="modal fade" id="viewEmpdetails-{{ $employee->EmployeeID }}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
               <h5>Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body table-responsive">
               <div class="card">
                  <div class="card-header" style="background-color:#ededed;">
                     <div style="float:left;width:100%;">
                        <h5 class="float-start">
						<b>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</b>
						<br>
						<div class="float-start" style="font-size:12px;">
							<b>Designation: {{ $employee->designation_name }} <br> Department: {{ $employee->department_name }}</b>

						</div>
                        </h5>
                     </div>
                  </div>
                  <div class="card-body table-responsive align-items-center">
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
                              <b>Employee: <span class="p-color">{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</span> </b>
                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Emp_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b> {{ $employee->Emp_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
                              <b>Appraiser: <span class="p-color">{{ $employee->Appraiser_Fname }} {{ $employee->Appraiser_Sname }} {{ $employee->Appraiser_Lname }}</span> </b>
                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Appraiser_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b>{{ $employee->Appraiser_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
                              <b>Reviewer: <span class="p-color">{{ $employee->Reviewer_Fname }} {{ $employee->Reviewer_Sname }} {{ $employee->Reviewer_Lname }}</span> </b>
                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Reviewer_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b>{{ $employee->Reviewer_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                     <div class="float-start" style="padding: 6px 0px !important;width:100%;border-bottom:1px solid #ddd;">
                        <div class="float-start">
                           <h6 class="has-btn" style="margin-top:6px;">
						   <b>HOD: <span class="p-color">{{ $employee->Rev2_Fname }} {{ $employee->Rev2_Sname }} {{ $employee->Rev2_Lname }}</span> </b>

                           </h6>
                        </div>
                        <div class="float-end">
                           <span class="me-3"><b>Score:</b><span class="r-color ms-2"><b>{{ $employee->Reviewer_TotalFinalScore }}</b></span></span>
                           <span><b>Rating:</b><span class="p-color ms-2 me-2"><b>{{ $employee->Reviewer_TotalFinalRating }}</b></span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
   @include('employee.footer')
   <script>
      $(document).ready(function() {
        // Assuming you have an array of ratings fetched from your Laravel controller and passed to JS
        const ratings = @json($ratings);  // The rating data you passed to JS from the controller
      
        // Event listener for changes in the editable input field
        $('.score-input').on('input', function() {
            let score = parseFloat($(this).val());
      let index = parseFloat($(this).data('employeeid')) || 0; // Get the target value from data attribute        
             console.log(index);
      // Find the rating based on the score
            let rating = getRatingForScore(score, ratings);
      $('#rating-input' + index).val(rating); // Update only the respective row's score cell
      
        });
        
        // Function to get the appropriate rating based on score
        function getRatingForScore(score, ratings) {
            // Loop through all the ratings and check if the score falls between the range
            for (let i = 0; i < ratings.length; i++) {
                if (score >= ratings[i].ScoreFrom && score <= ratings[i].ScoreTo) {
                    return ratings[i].Rating;
                }
            }
            return 'N/A';  // Default if no rating found
        }
      });
      $(document).ready(function () {
        $(".save-btn").on("click", function () {
            $('#loader').show();

            let employeeId = $(this).data("employeeid");  // Get Employee ID
            let pmsid = $(this).data("pmsid");  // Get Employee ID
            let companyid = $(this).data("companyid");  // Get Employee ID


            let score = $(".score-input[data-employeeid='" + employeeId + "']").val();  // Get Score
            let rating = $("#rating-input" + employeeId).val();  // Get Rating
			let remarksInput = $(".remarks-input[data-employeeid='" + employeeId + "']"); // Get Remarks Input
			let remarks = remarksInput.val().trim(); // Trim whitespace to ensure correct check

			// Check if remarks field is empty (after trimming whitespace)
			if (remarks === "") {
				remarksInput.css("border", "2px solid red"); // Add red border
				remarksInput.focus(); // Focus on the input field
				return; // Stop the function from proceeding
			} else {
				remarksInput.css("border", ""); // Remove red border if filled
			}
            // AJAX request to save data
            $.ajax({
                url: "/update-employee-score",  // Laravel route
                type: "POST",
                data: {
                    employeeId: employeeId,
                    score: score,
                    rating: rating,
                    remarks: remarks,
                    pmsid:pmsid,
                    companyid:companyid,
                    _token: $('meta[name="csrf-token"]').attr("content")  // CSRF Token
                },
                success: function(response) {
                     $('#loader').hide();

                     // Display success message
                     toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right",
                        "timeOut": 10000
                     });

                     // Optional: Reload the page or perform other actions
                     setTimeout(function() {
                        location.reload();
                     }, 2000);
               },
               error: function(xhr) {
                     $('#loader').hide();

                     // Display error message
                     let errorMessage = "An error occurred.";
                     if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                     }

                     toastr.error(errorMessage, 'Error', {
                        "positionClass": "toast-top-right",
                        "timeOut": 3000
                     });
               }
            });
        });
      });
      $(document).ready(function () {
        $(".score-input").on("input", function () {
            let employeeId = $(this).data("employeeid");  
            let enteredScore = parseFloat($(this).val()) || 0;  // Default to 0 if empty
            let reviewerScore = parseFloat($("td[data-reviewerscore='"+employeeId+"']").text()) || 0;  
            let inputField = $(this);
      
            let minAllowed = reviewerScore - 10;  
            let maxAllowed = reviewerScore + 10;
      
            // Find the error message block or create it
            let errorBlock = $(this).closest("td").find(".error-message");
      
            if (enteredScore < minAllowed || enteredScore > maxAllowed) {
                // Show error message if not already present
                if (errorBlock.length === 0) {
                    $(this).closest("td").append('<div class="error-message text-danger">Score must be within ±10 of Reviewer Score! Resetting to 0.00.</div>');
                }
                // Reset score to 0.00
                  // Set timeout to reset the value after 2 seconds
      	  setTimeout(function () {
                    inputField.val("0.00");
                    errorBlock.remove(); // Remove error message after reset
                }, 2000);
            } else {
                errorBlock.remove(); // Remove the error if within range
            }
        });
      });
      function showEmployeeDetails(employeeId) {
             var companyId = $('a[onclick="showEmployeeDetails(' + employeeId + ')"]').attr('data-companyid');
          
                     $.ajax({
                         url: '/employee/details/' + employeeId, // Ensure the route matches your Laravel route
                         method: 'GET',
                         success: function(response) {
                             console.log(response);
          
                             if (response.error) {
                                 alert(response.error);
                                 return;
                             }
          
                             // Helper function to check if the date is invalid or is a default date like "01/01/1970"
                             function isInvalidDate(date) {
                                 return date === "1970-01-01" || date === "0000-00-00" || date === "";
                             }
                             var image_url = `https://vnrseeds.co.in/AdminUser/EmpImg${companyId}Emp/${response.employeeDetails.EmpCode}.jpg`;
          
                             // Update modal content dynamically with employee details
                             $('#employeeName').text(response.employeeDetails.Fname + ' ' + response.employeeDetails.Sname + ' ' + response.employeeDetails.Lname);
                             $('#employeeCode').text(response.employeeDetails.EmpCode);
                             $('#designation').text(response.employeeDetails.designation_name);
                             $('#department').text(response.employeeDetails.department_name);
                             $('#dateJoining').text(formatDate(response.employeeDetails.DateJoining));
                             $('#employeeImage').attr('src', image_url);
          
                            
                             $('#totalExperienceYears').text(response.employeeDetails.YearsSinceJoining + ' Years ' +
                                 response.employeeDetails.MonthsSinceJoining + ' Months');
          
                             // **Handling Previous Experience Data**
                             var experienceData = response.previousEmployers || [];
                             console.log(experienceData);
          
                             // Empty the previous employer table before populating
                             var experienceTable = $('#experienceTable');
                             experienceTable.empty(); // Clear any previous data in the table
                             let totalYears = 0, totalMonths = 0;
          
                             experienceData.forEach(function(experience) {
                                 if (experience.DurationYears) {
                                     totalYears += parseInt(experience.DurationYears) || 0;
                                 }
                                 if (experience.DurationMonths) {
                                     totalMonths += parseInt(experience.DurationMonths) || 0;
                                 }
                             });
          
                             // Convert months to years if they exceed 12
                             totalYears += Math.floor(totalMonths / 12);
                             totalMonths = totalMonths % 12;
          
                             $('#totalprevExperienceYears').text(totalYears + ' Years ' + totalMonths + ' Months');
          
                             // Check if there's any previous experience data
                             if (experienceData.some(function(experience) {
                                     // Check if any of the values are not empty or null
                                     return experience.ExpComName.trim() !== '' ||
                                         experience.ExpDesignation.trim() !== '' ||
                                         experience.ExpFromDate !== null ||
                                         experience.ExpToDate !== null ||
                                         experience.DurationYears !== null;
                                 })) {
                                 // If there's any valid data, loop through and display it
                                 experienceData.forEach(function(experience, index) {
                                     // Format dates and duration
                                     var fromDate = isInvalidDate(experience.ExpFromDate) ? '-' : formatDate(
                                         experience.ExpFromDate);
                                     var toDate = isInvalidDate(experience.ExpToDate) ? '-' : formatDate(
                                         experience.ExpToDate);
                                     var duration = experience.DurationYears || '-';
          
                                     // Create the row for the table
                                     var row = `<tr>
                                 <td>${index + 1}</td>
                                 <td>${experience.ExpComName || '-'}</td>
                                 <td>${experience.ExpDesignation || '-'}</td>
                                 <td>${fromDate}</td>
                                 <td>${toDate}</td>
                                 <td>${duration}</td>
                             </tr>`;
          
                                     // Append the row to the table
                                     experienceTable.append(row);
                                 });
          
                                 // Show the "Previous Employers" section if there is valid data
                                 $('#prevh5').show(); // Show the "Previous Employers" heading
                                 $('#careerprev').show(); // Show the "Previous Employers" section
                                 $('#experienceTable').closest('table').show(); // Show the table
                             } else {
                                 // Hide the "Previous Employers" section if no valid data is available
                                 $('#prevh5').hide();
                                 $('#careerprev').hide();
                                 $('#experienceTable').closest('table').hide();
                             }
          
          
                             // **Handling Career Progression Data**
                             var careerProgressionData = response.careerProgression || [];
                             var careerProgressionTable = $('#careerProgressionTable');
                             careerProgressionTable.empty(); // Clear any previous data in the table
                             console.log(careerProgressionData);
                             // Check if there's any career progression data
                             if (Array.isArray(careerProgressionData) && careerProgressionData.length > 0) {
                                 careerProgressionData.forEach(function(progress, index) {
                                     var salaryDateRange = progress.Date|| '-';
                                     var grade = progress.Grade|| '-';
                                     var designation = progress.Designation|| '-';
          
                                     var monthly_gross = progress.Monthly_Gross|| '-';
                                     var ctc = progress.CTC|| '-';
                                     var rating = progress.Rating|| '-';
          
                                     var row = `<tr>
                                         <td>${index + 1}</td>
                                         <td>${salaryDateRange|| '-'}</td>
                                         <td>${grade || '-'}</td>
                                         <td>${designation|| '-'}</td>
                                         <td style="text-align: right;">${monthly_gross|| '-'}</td>
                                         <td style="text-align: right;">${ctc|| '-'}</td>
                                         <td style="text-align: right;">${rating|| '-'}</td>
                                     </tr>`;
          
                                     $('#careerProgressionTable').append(row);
                                 });
          
                                 // Show the Career Progression section if there's data
                                 $('#careerh5').show(); // Show the heading
                                 $('#careerProgressionTable').closest('table').show(); // Show the table
                             } else {
                                 // If no career progression data, hide the section
                                 $('#careerh5').hide();
                                 $('#careerProgressionTable').closest('table').hide();
                             }
          
          // Populate Training Programs Table
          var trainingTable = $('#trainingProgramsTable');
                   trainingTable.empty();
          
                   if (response.trainings.length > 0) {
                       response.trainings.forEach(function(training, index) {
                           var row = `<tr>
                               <td>${index + 1}</td>
                               <td>${training.TraTitle || '-'}</td>
                               <td>${formatDate(training.TraFrom)}</td>
                               <td>${training.Duration || '-'}</td>
                               <td>${training.Institute || '-'}</td>
                               <td>${training.TrainerName || '-'}</td>
                               <td>${training.Location || '-'}</td>
                           </tr>`;
                           trainingTable.append(row);
                       });
                   } else {
                       trainingTable.append(`<tr><td colspan="7" class="text-center">No training programs found</td></tr>`);
                   }
          
                   // Populate Conferences Table
                   var conferenceTable = $('#conferenceTable');
                   conferenceTable.empty();
          
                   if (response.conferences.length > 0) {
                       response.conferences.forEach(function(conference, index) {
                           var row = `<tr>
                               <td>${index + 1}</td>
                               <td>${conference.Title || '-'}</td>
                               <td>${formatDate(conference.ConfFrom)}</td>
                               <td>${conference.Duration || '-'}</td>
                               <td>${conference.ConductedBy || '-'}</td>
                               <td>${conference.Location || '-'}</td>
                           </tr>`;
                           conferenceTable.append(row);
                       });
                   } else {
                       conferenceTable.append(`<tr><td colspan="6" class="text-center">No conferences attended</td></tr>`);
                   }
                             // Show the modal
                             $('#empdetails').modal('show');
                         },
                         error: function(xhr, status, error) {
                             console.log('AJAX error:', status, error);
                             alert('An error occurred while fetching the data.');
                         }
                     });
                 }
          function formatDate(dateString) {
             if (!dateString) return '-';
             var date = new Date(dateString);
             var day = ("0" + date.getDate()).slice(-2);
             var month = ("0" + (date.getMonth() + 1)).slice(-2);
             var year = date.getFullYear();
             return day + '-' + month + '-' + year;
          }
      
          document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("sortGrade").addEventListener("click", function() {
            let table = document.querySelector("table tbody");
            let rows = Array.from(table.querySelectorAll("tr"));
            
            let ascending = this.dataset.order === "asc";
            this.dataset.order = ascending ? "desc" : "asc";

            rows.sort((a, b) => {
                let gradeA = a.cells[4].innerText.trim().toLowerCase();
                let gradeB = b.cells[4].innerText.trim().toLowerCase();

                return ascending ? gradeA.localeCompare(gradeB) : gradeB.localeCompare(gradeA);
            });

            rows.forEach(row => table.appendChild(row)); // Reorder table rows
        });
    });
    $(document).ready(function () {
    function filterTable() {
        var department = $('#department-filter').val().toLowerCase();
        var state = $('#state-filter').val().toLowerCase();
        var grade = $('#grade-filter').val().toLowerCase();
        var region = $('#region-filter').val().toLowerCase();

        var visibleIndex = 1; // Counter for S. No.

        $('#employeetablemang tbody tr').each(function () {
            var rowDepartment = $(this).find('td:nth-child(4)').text().toLowerCase();
            var rowState = $(this).find('td:nth-child(6)').text().toLowerCase();
            var rowGrade = $(this).find('td:nth-child(5)').text().toLowerCase();
            var rowRegion = $(this).find('td:nth-child(7)').text().toLowerCase();

            if ((department === "" || rowDepartment === department) &&
                (state === "" || rowState === state) &&
                (grade === "" || rowGrade === grade) &&
                (region === "" || rowRegion === region)) {
                $(this).show();
                $(this).find('td:nth-child(1)').text(visibleIndex); // Update S. No.
                visibleIndex++;
            } else {
                $(this).hide();
            }
        });
    }

    // Show/hide the region filter based on department selection
    $('#department-filter').change(function () {
        var selectedDepartment = $(this).val();
        if (selectedDepartment === "Sales") {
            $('#region-filter').show(); // Show region filter
        } else {
            $('#region-filter').hide(); // Hide region filter
            $('#region-filter').val(''); // Reset region selection
        }
        filterTable();
    });

    // Trigger filtering when any dropdown changes
    $('#department-filter, #state-filter, #grade-filter, #region-filter').change(function () {
        filterTable();
    });

    // Hide region filter initially
         $('#region-dropdown').hide();

         // Initial filter application
         filterTable();
      });

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.edit-score').forEach(editBtn => {
        editBtn.addEventListener('click', function (e) {
            e.preventDefault();
            
            let employeeId = this.getAttribute("data-employeeid");

            // Select the Save button corresponding to this employee
            let saveBtn = document.querySelector(`.save-btn[data-employeeid='${employeeId}']`);

            // Select input fields for score and remarks
            let scoreInput = document.querySelector(`input[data-employeeid='${employeeId}'][name='score']`);
            let remarkInput = document.querySelector(`input[data-employeeid='${employeeId}'][name='remark']`);

            // Make input fields editable
            if (scoreInput) scoreInput.removeAttribute("readonly");
            if (remarkInput) remarkInput.removeAttribute("readonly");

            // Show the Save button
            if (saveBtn) saveBtn.style.display = "inline-block";
        });
    });
});

   
   </script>

   <style>
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