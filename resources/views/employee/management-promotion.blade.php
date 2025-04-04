@include('employee.header')

<body class="mini-sidebar">
	@include('employee.sidebar')
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
													<li class="mt-1"><a  id="home-tab1"
														href="{{route('managementAppraisal')}}" role="tab"
														aria-controls="home" aria-selected="true">Score <i
															class="fas fa-star mr-2"></i></a></li>
													<li class="mt-1"><a class="active" id="Promotion-tab20"
														data-bs-toggle="tab" href="#Promotion" role="tab"
														aria-controls="Promotion" aria-selected="false">Promotion
														<i class="fas fa-file-alt mr-2"></i></a></li>
													<li class="mt-1"><a class="" id="Increment-tab21"
														href="{{route('managementIncrement')}}" role="tab"
														aria-controls="Increment" aria-selected="false">Increment <i class="fas fa-file-invoice mr-2"></i></a></li>
												</ul>
											</div>
											<div class="tab-content splash-content2" id="myTabContent2">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 tab-pane fade active show"
                                                    id="Promotion" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color:#A8D0D2;">
                                                            <b>Team Promotion</b>
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
																	<a title="PDF" href=""><i class="fas fa-file-pdf mr-2 ms-2"></i></a> |
																	<a title="Print" href=""><i class="fas fa-print mr-2 ms-2"></i></a>
																</div>
															<a class="effect-btn btn btn-success squer-btn sm-btn float-end">Final Submit <i class="fas fa-check-circle mr-2"></i></a>
                                                        </div>
														<div class="card-body table-responsive dd-flex align-items-center">
															<table class="table table-pad" id="employeetablemang">
																<thead>
																	<tr>
																		<th rowspan="2" style="text-align:center;">SN.</th>
																		<th class="text-center" colspan="4" style="border-right: 1px solid #fff;border-left:1px solid #fff;">Employee</th>
																		<th class="text-center" colspan="2" style="border-right: 1px solid #fff;">Appraiser [Proposed]</th>
																		<th class="text-center" colspan="2" style="border-right: 1px solid #fff;">Reviewer [Proposed]</th>
																		<th rowspan="2" style="text-align:center;">Promotion<br> Details</th>
																		<th class="text-center" colspan="3" style="border-right: 1px solid #fff;border-left: 1px solid #fff;">Management [Proposed]</th>
																		<th rowspan="2" style="text-align:center;">Action</th>
																		
																	</tr>
																	<tr>
																		<th class="text-center" style="border-left: 1px solid #fff;">EC</th>
																		<th class="text-center">Name</th>
																		<th class="text-center">Department</th>
                                                   						<th id="sortGrade" class="text-center" style="cursor: pointer;">Grade ⬍</th>
																		
																		<th class="text-center">Designation</th>
																		<th class="text-center" style="border-right: 1px solid #fff;">Grade</th>
																		<th class="text-center">Designation</th>
																		<th class="text-center" style="border-right: 1px solid #fff;">Grade</th>
																		<th class="text-center">Designation</th>
																		<th class="text-center" style="border-right: 1px solid #fff;">Grade</th>
														
																		<th class="text-center" style="border-right: 1px solid #fff;">Remaks</th>
																		
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

																		<td class="text-center">-</td>
																		<td class="text-center">-</td>
																		<td class="text-center">-</td>
																		<td class="text-center">-</td>
																		<td class="text-center"><a title="Promotion History" data-bs-toggle="modal" data-bs-target="#PromotionHistory"><i class="fas fa-eye mr-2"></i></a></td>
																		
																		<td>
																			<select style="width:150px;">
																				<option>Select</option>
																				<option>1</option>
																				<option>1</option>
																			</select>
																		</td>
																		<td>
																			<select>
																				<option>Select</option>
																				<option>1</option>
																				<option>1</option>
																			</select>
																		</td>
																		<td><input class="form-control" style="width:215px;" placeholder="Enter your remarks"></input></td>
																		<td class="text-center">
																			<a title="Save" href=""><i style="font-size:14px; display:none;" class="ri-save-3-line text-success mr-2"></i></a> 
																			<a title="Edit" data-bs-toggle="modal" data-bs-target="#"> <i class="fas fa-edit"></i></a> 
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

<!--view PromotionHistory Modal-->
<div class="modal fade show" id="PromotionHistory" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title me-2"  style="font-size:13px;">
			<img src="./images/user.jpg"><br>
			EC: 1254
			</h5>
			<table class="table mb-0">
				<tr>
					<td colspan="3"><b>Kishan Kumar</b></td>
					<td colspan=""><b>DOJ: 07-03-2019</b></td>
				</tr>
				<tr>
					<td><b>Designation:</b></td>
					<td style="color:#DC7937;"><b>Ex. Software Developer</b></td>
					<td><b>Function:</b></td>
					<td style="color:#DC7937;"><b>Business Operations</b></td>
					
				</tr>
				<tr>
					<td><b>VNR Exp.</b></td>
					<td style="color:#DC7937;"><b>5.8 Year</b></td>
					<td><b>Rrev. Exp.</b></td>
					<td style="color:#DC7937;"><b>9.00 Year</b></td>
				</tr>
			</table>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
		</div>
		<div class="modal-body table-responsive">
		<div class="card">
			<div class="card-header">
				<div style="float:left;width:100%;">
					<h5 class="float-start"><b>Career Progression in VNR</b></h5>
				</div>
			</div>
			<div class="card-body table-responsive align-items-center">
				<table class="table table-pad">
					<thead>
						<tr>
							<th>SN.</th>
							<th>Date</th>
							<th>Designation</th>
							<th>Grade</th>
							
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>1.</b></td>
							<td>12-06-2024</td>
							<td>Territory Business Manager</td>
							<td>J4</td>
						</tr>
						<tr>
							<td><b>2.</b></td>
							<td>21-04-2016</td>
							<td>Territory Sales Executive</td>
							<td>J4</td>
						</tr>
						<tr>
							<td><b>3.</b></td>
							<td>12-06-2012</td>
							<td>Sales Executive</td>
							<td>J4</td>
						</tr>
						<tr>
							<td><b>4.</b></td>
							<td>12-06-2010</td>
							<td>Sales Officer</td>
							<td>J4</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		</div>
	</div>
	</div>
</div>
@include('employee.footer')
<script>
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
</script>