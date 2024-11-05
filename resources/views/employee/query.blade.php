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
                                    <li class="breadcrumb-link active">Query</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
							<div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title">Send Query</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
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
                                                <label for="Department_name" class="col-form-label"><b>Select Department Name</b></label>
                                                <select class="select2 form-control select-opt" id="Department_name" name="Department_name">
                                                    <option value="" disabled selected>Select a department</option>
                                                    @php
                                                        $departments = Auth::user()->departments;
                                                    @endphp
                                                    
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->DepartmentId }}">{{ $department->DepartmentName }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="sel_arrow">
                                                    <i class="fa fa-angle-down"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name_sub" class="col-form-label"><b>Select Subject</b></label>
                                                <select class="select2 form-control select-opt" id="Department_name_sub" name="Department_name_sub">
                                                    <option value="" disabled selected>Select a Subject</option>
                                                    @php
                                                        $departments_sub = Auth::user()->departmentsWithQueries;
                                                    @endphp
                                                    
                                                    @foreach ($departments_sub as $department_sub)
                                                        <option value="{{ $department_sub->DeptQSubject }}" id-sub_department="{{ $department_sub->DeptQSubId }}" data-department="{{ $department_sub->DepartmentId }}">
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
                                                <textarea class="form-control" placeholder="Additional Remarks" id="remarks" name="remarks"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="checkbox">
                                                <input id="checkbox3" type="checkbox" name="hide_name">
                                                <label for="checkbox3">Do you want to hide your name from Reporting Manager & HOD?</label>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-0">
                                            <button class="btn btn-primary" type="reset">Reset</button>
                                            <button class="btn btn-success" type="submit">Submit</button>
                                        </div>
                                    </div>
								</form>

								</div>
                            </div>
                        </div>
					
                        </div>
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="card chart-card">
								<div class="card-header">
									<h4 class="has-btn">Query List</h4> 
								</div>
								<div class="card-body table-responsive">
									<table class="table">
										<thead class="thead-light" style="background-color:#f1f1f1;">
											<tr style="background-color:#ddd;">
												<th colspan="5">Query Details</th>
												<th colspan="4">Status</th>
												<th colspan="2">Self Action</th>
											</tr>
											<tr>
												<th>Sno.</th>
												<th>Date</th>
												<th>Subject</th>
												<th>Details</th>
												<th>Department</th>
												<th>Level 1</th>
												<th>Level 2</th>
												<th>Level 3</th>
												<th>Action</th>
												<th>Rating</th>
											</tr>
										</thead>
                                        <tbody id="queryTableBody">
                                        @php
												$queryList = Auth::user()->queryMap; 
												$departments = Auth::user()->departments->keyBy('DepartmentId'); // Key by DepartmentId for quick lookup

											@endphp

											@foreach ($queryList as $index => $query)
										
												<tr>
													<td>{{ $index + 1 }}.</td>
													<td>{{ \Carbon\Carbon::parse($query->QueryDT)->format('j F Y') }}</td>
													<td>{{ $query->QuerySubject }}</td> 
													<td>{{ $query->QueryValue }}</td> 
													<td>{{ $departments[$query->QToDepartmentId]->DepartmentName ?? 'N/A' }}</td> <!-- Fetch department name -->
													<td>{{ $query->Level_1QStatus ?? '-' }}</td>
													<td>{{ $query->Level_2QStatus ?? '-' }}</td>
													<td>{{ $query->Level_3QStatus ?? '-' }}</td>
													<td>{{ $query->Mngmt_QAction ?? '-' }}</td>
													<td>{{ $query->EmpQRating ?? '-' }}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									<p><b>Note:</b> Kindly rate the closed queries as per your satisfaction levels on the overall query resolution process. When you shall consider the parameters: (1 Being not satisfied, 5 for highly satisfied)</p>
								</div>
							</div>
						</div>

					
                </div>
                <!-- Revanue Status Start -->
                <div class="row">
                    
                </div>
                
				<div class="ad-footer-btm">
					<p><a href="">Terms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Private Limited India</p>
				</div>
            </div>
        </div>
    </div>
   <!--General message-->
    <div class="modal fade show" id="assetdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle3">Details of Assets</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6 ">
						<p class="mb-2"><b>Request Date:</b> 04 Apr 2024</p>
						<p class="mb-2"><b>Type Of Asset:</b> Laptop</p>
						<p class="mb-2"><b>Balance Amount:</b> 15,000/-</p>
					</div>
					<div class="col-md-6">
						<p class="mb-2"><b>Request Amount:</b> 35,000/-</p>
						<p class="mb-2"><b>Approval Amount:</b> 35,000/-</p>
						
					</div>
					<div class="col-md-12 mb-2"><p style="border:1px solid #ddd;"></p></div>
					<div class="col-md-6">
						<p class="mb-2"><b>Copy Of Bill</b></p>
						<img style="width:250px;" src="./images/excel-invoice.jpg" />
					</div>
					<div class="col-md-6">
						<p class="mb-2"><b>Copy Of Asset</b></p>
						<img style="width:250px;" src="./images/excel-invoice.jpg" />
					</div>
					<div class="col-md-12">			
						<p><b>Details:</b></p> 
					</div>
					
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
			
			</div>
		  </div>
		</div>
    </div>
	
	<div class="modal fade show" id="billdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			<h5 class="modal-title" id="exampleModalCenterTitle3">Details of Assets</h5>
			<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">×</span>
			</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<img class="w-100" src="./images/excel-invoice.jpg" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
			</div>
		  </div>
		</div>
    </div>

@include('employee.footer');
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#queryForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
		const url= $(this).attr('action'); // Form action URL

        $.ajax({
            url: $(this).attr('action'), // Form action URL
            type: 'POST',
            data: $(this).serialize(), 
			
            success: function(response) {
                $('#message').removeClass('alert-danger').addClass('alert-success').text('Form submitted successfully!').show();
                $('#queryForm')[0].reset();
                // setTimeout(function() {
                //     location.reload();
                // }, 3000);
            },
            error: function(xhr, status, error) {
                $('#message').removeClass('alert-success').addClass('alert-danger').text('An error occurred: ' + error).show();
            }
        });
    });
});

	    document.getElementById('Department_name').addEventListener('change', function() {
        var selectedDepartmentId = this.value; // Get selected department ID
        var subjectSelect = document.getElementById('Department_name_sub');
        
        // Clear current subjects
        subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
        
        // Loop through all subject options
        var options = @json($departments_sub); // Get subjects as a JSON array
        options.forEach(function(department_sub) {
            if (department_sub.DepartmentId == selectedDepartmentId) {
                var option = document.createElement('option');
                option.value = department_sub.DeptQSubject;
                option.text = department_sub.DeptQSubject;
                subjectSelect.appendChild(option);
            }
        });
    });
</script>

