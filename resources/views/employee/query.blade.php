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
               <div class="col-12">
                  <!-- Start of Tabs Section -->
                  <div class="nav-tabs-custom">
                     <ul class="nav nav-tabs" id="queryTabs" role="tablist">
                        <li class="nav-item">
                           <a style="color: #0e0e0e;" id="queryFormTab" class="nav-link active"
                              data-bs-toggle="tab" href="#queryFormSection" role="tab"
                              aria-controls="queryFormSection" aria-selected="true">My Query</a>
                        </li>
                        <li class="nav-item">
                           <a style="color: #0e0e0e;" id="employeeQueryTab" class="nav-link"
                              data-bs-toggle="tab" href="#employeeQuerySection" role="tab"
                              aria-controls="employeeQuerySection" aria-selected="true">Employee Specific
                           Queries</a>
                        </li>
                     </ul>
                     <div class="tab-content">
                        <!-- Query Form Section Tab -->
                        <div class="tab-pane fade show active" id="queryFormSection" role="tabpanel"
                           aria-labelledby="queryFormTab">
                           <div class="row">
                              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                 <div class="card">
                                    <div class="card-header pb-0">
                                       <h4 class="card-title">Send Query</h4>
                                    </div>
                                    <div class="card-content">
                                       <div class="card-body">
                                          <div id="message" class="alert" style="display: none;"></div>
                                          <form id="queryForm" action="{{ route('querysubmit') }}"
                                             method="POST">
                                             @csrf
                                             <input type="hidden" name="employee_id"
                                                value="{{ Auth::user()->EmployeeID }}">
                                             <div class="row">
                                                <div
                                                   class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                   <p>CC to your reporting manager & HOD</p>
                                                </div>
                                                <div
                                                   class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                   <div class="form-group s-opt">
                                                      <label for="Department_name"
                                                         class="col-form-label"><b>Select Department
                                                      Name</b></label>
                                                      <select class="select2 form-control select-opt"
                                                         id="Department_name" name="Department_name">
                                                         <option value="" disabled selected>Select a
                                                            department
                                                         </option>
                                                         @php
                                                         $departments = Auth::user()->departments;
                                                         @endphp
                                                         @foreach ($departments as $department)
                                                         <option
                                                            value="{{ $department->DepartmentId }}">
                                                            {{ $department->DepartmentName }}
                                                         </option>
                                                         @endforeach
                                                      </select>
                                                      <span class="sel_arrow">
                                                      <i class="fa fa-angle-down"></i>
                                                      </span>
                                                   </div>
                                                </div>
                                                <div
                                                   class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                   <div class="form-group s-opt">
                                                      <label for="Department_name_sub"
                                                         class="col-form-label"><b>Select
                                                      Subject</b></label>
                                                      <select class="select2 form-control select-opt"
                                                         id="Department_name_sub"
                                                         name="Department_name_sub">
                                                         <option value="" disabled selected>Select a
                                                            Subject
                                                         </option>
                                                         @php
                                                         $departments_sub = Auth::user()->departmentsWithQueries;
                                                         @endphp
                                                         @foreach ($departments_sub as $department_sub)
                                                         <option
                                                            value="{{ $department_sub->DeptQSubject }}"
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
                                                <div
                                                   class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                   <div class="form-group">
                                                      <label for="remarks"
                                                         class="col-form-label"><b>Remarks</b></label>
                                                      <textarea class="form-control"
                                                         placeholder="Additional Remarks"
                                                         id="remarks" name="remarks"></textarea>
                                                   </div>
                                                </div>
                                                <div
                                                   class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                                   <div class="checkbox">
                                                      <input id="checkbox3" type="checkbox"
                                                         name="hide_name">
                                                      <label for="checkbox3">Do you want to hide your
                                                      name from Reporting Manager & HOD?</label>
                                                   </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                   <button class="btn btn-primary"
                                                      type="reset">Reset</button>
                                                   <button class="btn btn-success"
                                                      type="submit">Submit</button>
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
                                       <div id="message-container"></div>
                                       <table class="table">
                                       <thead class="thead-light" style="background-color:#f1f1f1; text-align: center;">
                                             <tr style="background-color:#ddd;">
                                                <th colspan="5">Query Details</th>
                                                <th colspan="3">Status</th>
                                                <th colspan="1">Action</th>
                                             </tr>
                                             @php
                                                   // Define the status mapping and first letter for each status
                                                   $statusMap = [
                                                      0 => 'Open',
                                                      1 => 'InProcess',
                                                      2 => 'Reply',
                                                      3 => 'Close',
                                                      4 => 'Esclose',
                                                   ];

                                                @endphp
                                             <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Details</th>
                                                <th>Department</th>
                                                <th>Level 1</th>
                                                <th>Level 2</th>
                                                <th>Level 3</th>
                                                <!-- <th>Action</th> -->
                                                <th>Rating</th>
                                             </tr>
                                          </thead>
                                          <tbody id="queryTableBody">
                                             @php
                                             $queryList = Auth::user()->queryMap;
                                             $departments = Auth::user()->departments->keyBy('DepartmentId'); // Key by DepartmentId for quick lookup
                                             @endphp
                                             @foreach ($queryList as $index => $query)
                                             <tr data-query-id="{{ $query->QueryId }}">
                                                <td>{{ $index + 1 }}.</td>
                                                <td>{{ \Carbon\Carbon::parse($query->QueryDT)->format('j F Y') }}
                                                </td>
                                                <td>{{ $query->QuerySubject }}</td>
                                                <td>{{ $query->QueryValue }}</td>
                                                <td>{{ $departments[$query->QToDepartmentId]->DepartmentName ?? 'N/A' }}
                                                </td>
                                                <!-- Fetch department name -->
                                                <td>
                                                      <span class="badge badge-pill {{ $query->Level_1QStatus === 3 ? 'bg-success' : 'bg-secondary' }} text-sm">
                                                         {{ $statusMap[$query->Level_1QStatus] ?? '-' }}
                                                      </span>
                                                   </td>
                                                   <td>
                                                      <span class="badge badge-pill {{ $query->Level_2QStatus === 3 ? 'bg-success' : 'bg-secondary' }} text-sm">
                                                         {{ $statusMap[$query->Level_2QStatus] ?? '-' }}
                                                      </span>
                                                   </td>
                                                   <td>
                                                      <span class="badge badge-pill {{ $query->Level_3QStatus === 3 ? 'bg-success' : 'bg-secondary' }} text-sm">
                                                         {{ $statusMap[$query->Level_3QStatus] ?? '-' }}
                                                      </span>
                                                   </td>

                                                <!-- <td>{{ $query->Mngmt_QAction ?? '-' }}</td> -->
                                                <td>
                                                      @php
                                                      $rating = $query->EmpQRating ?? 0; // Default to 0 if no rating is provided
                                                      @endphp
                                                      <!-- Display stars based on the rating -->
                                                      <span class="stars">
                                                         @for ($i = 1; $i <= 5; $i++)
                                                               <i class="fa fa-star star {{ $i <= $rating ? 'text-success' : 'text-muted' }}" 
                                                                  data-value="{{ $i }}" 
                                                                  data-query-id="{{ $query->QueryId }}" 
                                                                  style="cursor: pointer;"></i>
                                                         @endfor
                                                      </span>
                                                   </td>


                                             </tr>
                                             @endforeach
                                          </tbody>
                                       </table>
                                       <p><b>Note:</b> Kindly rate the closed queries as per your
                                          satisfaction levels on the overall query resolution process.
                                          When you shall consider the parameters: (1 Being not satisfied,
                                          5 for highly satisfied)
                                       </p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Employee Specific Query Section Tab -->
                        <div class="tab-pane fade" id="employeeQuerySection" role="tabpanel"
                           aria-labelledby="employeeQueryTab">
                           <div class="row">
                              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                 <div class="card">
                                    <div class="card-header pb-0">
                                       <h4 class="card-title">Employee Specific Queries</h4>
                                    </div>
                                    <div class="card-body table-responsive">
                                       <table class="table" id="employeeQueryListTable">
                                          <thead class="thead-light" style="background-color:#f1f1f1;">
                                             <tr style="background-color:#ddd;">
                                                <th>Sno.</th>
                                                <th>Employee Details</th>
                                                <th>Query Details</th>
                                                <th>Level 1 Status</th>
                                                <th>Level 2 Status</th>
                                                <th>Level 3 Status</th>
                                                <th>Management Action</th>
                                                <th>Take Action</th>
                                             </tr>
                                          </thead>
                                          <tbody id="employeeQueryTableBody">
                                             <!-- Dynamic content for employee-specific queries will be inserted here -->
                                          </tbody>
                                       </table>
                                       <p id="noEmployeeQueriesMessage" style="display: none;">No queries
                                          found for this employee.
                                       </p>
                                       <!-- Message to show if no queries -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End of Tabs Section -->
               </div>
            </div>
            <!-- Dashboard End -->
            @include('employee.footerbottom')

         </div>
      </div>
   </div>
   <!--General message-->
   <div class="modal fade show" id="assetdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
      style="display: none;" aria-modal="true" role="dialog">
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
                  <div class="col-md-12 mb-2">
                     <p style="border:1px solid #ddd;"></p>
                  </div>
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
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                  data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal for taking action -->
   <div id="actionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="actionModalLabel">Query Action</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div id="actionMessage" class="alert" style="display: none;">
                  <!-- This will display the message from the server -->
               </div>
               <form id="queryActionForm">
                  @csrf <!-- CSRF Token will be added here automatically -->
                  <!-- Form Fields -->
                  <div class="form-group">
                     <label for="querySubject">Subject</label>
                     <input type="text" id="querySubject" class="form-control" name="querySubject" readonly>
                  </div>
                  <div class="form-group">
                     <label for="querySubjectValue">Subject Details</label>
                     <input type="text" id="querySubjectValue" class="form-control" name="querySubjectValue"
                        readonly>
                  </div>
                  <div class="form-group">
                     <label for="queryName">Employee Name</label>
                     <input type="text" id="queryName" class="form-control" name="queryName" readonly>
                  </div>
                  <div class="form-group">
                     <label for="queryDepartment">Query Department</label>
                     <input type="text" id="queryDepartment" class="form-control" name="queryDepartment"
                        readonly>
                  </div>
                  <div class="form-group">
                     <label for="status">Status</label>
                     <select id="status" class="form-control" name="status">
                        <option value="0">Open</option>
                        <option value="1">In Progress</option>
                        <option value="2">Reply</option>
                        <option value="4">Esclose</option>
                        <option value="3">Closed</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="reply">Reply</label>
                     <textarea id="reply" class="form-control" name="reply" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                     <label for="forwardTo">Forward To</label>
                     <select id="forwardTo" class="form-control" name="forwardTo">
                        <option value="0">Select a Forward To</option>
                        <!-- Default option with value 0 -->
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="forwardReason">Forward Reason</label>
                     <textarea id="forwardReason" class="form-control" name="forwardReason" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Save Action</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade show" id="billdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
      style="display: none;" aria-modal="true" role="dialog">
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
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                  data-bs-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   @include('employee.footer');
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
   $(document).ready(function () {
    // Handle form submission
    $('#queryForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission
        const url = $(this).attr('action'); // Form action URL

        $.ajax({
            url: url, // Form action URL
            type: 'POST',
            data: $(this).serialize(), // Serialize the form data

            success: function (response) {
                // Display success message
                $('#message').removeClass('alert-danger').addClass('alert-success').text('Form submitted successfully!').show();

                // Reset the form
                $('#queryForm')[0].reset();

                // Refresh the table body with updated data
                refreshQueryTable();

                // Optionally, hide the success message after 3 seconds
                setTimeout(function () {
                    $('#message').hide();
                }, 3000); // 3 seconds
            },
            error: function (xhr, status, error) {
                // Display error message
                $('#message').removeClass('alert-success').addClass('alert-danger').text('An error occurred: ' + error).show();

                // Optionally, hide the error message after 3 seconds
                setTimeout(function () {
                    $('#message').hide();
                }, 3000); // 3 seconds
            }
        });
    });
});

// Function to refresh the query list table body
function refreshQueryTable() {
    $.ajax({
        url: window.location.href, // Refresh the current page's content
        type: 'GET',
        success: function (response) {
            // Extract the new table body HTML from the response
            var newTableBody = $(response).find('#queryTableBody').html();

            // Replace the old table body with the new one
            $('#queryTableBody').html(newTableBody);

            // Rebind the star selection event after the table is refreshed
            rebindStarSelection();
        },
        error: function () {
            $('#message').removeClass('alert-success').addClass('alert-danger').text('Failed to refresh the table.').show();
        }
    });
}

// Rebind the star selection event after the table is refreshed
function rebindStarSelection() {
   // Handle star click to select multiple stars
   $('.star').on('click', function() {
      var queryId = $(this).data('query-id');  // Get the QueryId for the clicked star
      var rating = $(this).data('value');      // Get the value of the clicked star
      
      // Update the stars in the UI based on the clicked star
      $(this).siblings().removeClass('text-success').addClass('text-muted');
      $(this).prevAll().addClass('text-success');
      $(this).addClass('text-success');
      
      // Allow for the possibility of selecting multiple stars
      if ($(this).hasClass('text-muted')) {
          $(this).removeClass('text-muted').addClass('text-success');
      } else {
          $(this).addClass('text-muted').removeClass('text-success');
      }
      
      // Send the selected rating to the server via AJAX
      var selectedRating = 0;
      $(this).siblings().addBack().each(function() {
          if ($(this).hasClass('text-success')) {
              selectedRating++;
          }
      });
      
      // Send the selected rating to the server
      $.ajax({
          url: '/update-query-rating',  // Your route for handling the rating update
          type: 'POST',
          data: {
              queryId: queryId,
              rating: selectedRating,
              _token: '{{ csrf_token() }}'  // Include CSRF token for security
          },
          success: function(response) {
              // Show success or error message above the table based on the response
              var message = response.message;
              var messageType = response.success ? 'success' : 'error';
      
              // Clear any previous messages
              $('#message-container').html('');
              $('#message-container').html('<div class="alert alert-' + messageType + '">' + message + '</div>');
      
              // Update the rating in the current row (if necessary)
              if (response.success) {
                  // You could also update other elements here if needed
                  // Just update the current row with the new rating
                  updateRatingDisplay(queryId, selectedRating);
              }
      
              // Make the message disappear after 3 seconds
              setTimeout(function() {
                  $('#message-container').html('');
              }, 3000); // 3 seconds delay
          },
          error: function(xhr, status, error) {
              // Handle AJAX error
              $('#message-container').html('<div class="alert alert-danger">An error occurred while updating the rating.</div>');
              setTimeout(function() {
                  $('#message-container').html('');
              }, 3000); // 3 seconds delay
          }
      });
      });
      
}


      
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
      
      $(document).ready(function () {
          // Fetch employee queries when the page loads or refreshes
          fetchEmployeeQueries();
      
          function fetchEmployeeQueries() {
              $.ajax({
                  url: '{{ route("employee.queries") }}', // Define the route for employee-specific queries
                  method: 'GET',
                  success: function (response) {
                      if (response.length > 0) {
                          $('#employeeQueryTableBody').empty(); // Clear the employee-specific table body first
      
                          // Loop through each query and append to the table
                          $.each(response, function (index, query) {
                              var row = '<tr>' +
                                  '<td>' + (index + 1) + '.</td>' +
                                  '<td>' +
                                  '<strong>Name:</strong> ' + query.Fname + ' ' + query.Sname + ' ' + query.Lname + '<br>' + // Combine Fname, Sname, Lname
                                  '</td>' +
                                  '<td>' +
                                  '<strong>Subject:</strong> ' + query.QuerySubject + '<br>' +
                                  '<strong>Subject Details:</strong> ' + query.QueryValue + '<br>' +
                                  '<strong>Query to:</strong> ' + query.DepartmentName + '<br>' +
                                  '</td>' +
                                  '<td>' + query.Level_1QStatus + '</td>' +
                                  '<td>' + query.Level_2QStatus + '</td>' +
                                  '<td>' + query.Level_3QStatus + '</td>' +
                                  '<td>' + query.Mngmt_QStatus + '</td>' +
                                  '<td>' +
                                  // Check if Level_1QStatus is 3 to disable the button
                                  (query.Level_1QStatus == 3 ?
                                      '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Action</button>' :
                                      '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action</button>'
                                  ) +
                                  '</td>' +
                                  '</tr>';
                              $('#employeeQueryTableBody').append(row);
                          });
      
                          // Attach event listener to the "Take Action" buttons
                          // Attach event listener to the "Take Action" buttons
                          $('.take-action-btn').on('click', function () {
                              var queryId = $(this).data('query-id');
      
                              var query = response.find(q => q.QueryId == queryId); // Find the query by ID
      
                              // Populate modal fields with query data
                              $('#querySubject').val(query.QuerySubject);
                              $('#querySubjectValue').val(query.QueryValue);
                              $('#queryName').val(query.Fname + ' ' + query.Sname + ' ' + query.Lname);
                              $('#queryDepartment').val(query.DepartmentName);
                              $('#status').val(query.Status);
                              $('#reply').val('');
                              $('#forwardTo').empty(); // Clear the forwardTo dropdown
      
                              // Add the default option (value 0) for the "Forward To" dropdown
                              $('#forwardTo').append('<option value="0">Select a Forward To</option>');
      
                              // Fetch the DeptQSubject and AssignEmpId for the department and populate the "Forward To" dropdown
                              fetchDeptQuerySubForDepartment(queryId);
      
                              // Store query ID in the form
                              $('#queryActionForm').data('query-id', queryId);
      
                              // Show the modal
                              $('#actionModal').modal('show');
                          });
      
                      } else {
                          $('#noEmployeeQueriesMessage').show(); // If no queries are found
                          $('#employeeQueryTab').hide(); // Hide the Employee Query tab
                          $('#employeeQuerySection').hide(); // Hide the Employee Specific Query section
                      }
                  },
                  error: function () {
                      console.log("Error fetching employee-specific queries.");
                  }
              });
          }
      
          // Function to fetch DeptQSubject and AssignEmpId for a specific department and populate the "Forward To" dropdown
          function fetchDeptQuerySubForDepartment(queryid) {
              $.ajax({
                  url: '{{ route("employee.deptqueriesub") }}', // Backend route to fetch DeptQSubject and AssignEmpId
                  method: 'GET',
                  data: { queryid: queryid },
                  success: function (response) {
                      console.log(response); // To check the response structure
      
                      // Clear the dropdown before adding new items
                      $('#forwardTo').empty();
      
                      // Add the default option (value 0) for the "Forward To" dropdown
                      $('#forwardTo').append('<option value="0">Select a Forward To</option>');
      
                      if (response.length > 0) {
                          // Populate the "Forward To" dropdown with options
                          $.each(response, function (index, item) {
                              var option = $('<option></option>')
                                  .attr('value', item.AssignEmpId) // Set the value to AssignEmpId
                                  .data('deptqsubject', item.DeptQSubject) // Store DeptQSubject as data
                                  .text(item.DeptQSubject); // Display DeptQSubject in the dropdown
                              $('#forwardTo').append(option);
                          });
                      } else {
                          alert('No query subjects found for this department.');
                      }
                  },
                  error: function () {
                      console.log("Error fetching department query subjects.");
                  }
              });
          }
          // Handle form submission
          // Handle form submission
          $('#queryActionForm').on('submit', function (e) {
              e.preventDefault(); // Prevent the default form submission
              var queryId = $(this).data('query-id');
      
              // Serialize the form data (this automatically includes the CSRF token)
              var formData = $(this).serialize();
              var selectedOption = $('#forwardTo option:selected');
              var deptQSubject = selectedOption.data('deptqsubject'); // Get DeptQSubject from the selected option
              var assignEmpId = selectedOption.val(); // Get AssignEmpId from the selected option
              var forwardReason = $('#forwardReason').val(); // Get Forward Reason value
              // Append the selected DeptQSubject and AssignEmpId to the form data
              formData += '&deptQSubject=' + deptQSubject + '&assignEmpId=' + assignEmpId + '&query_id=' + queryId + '&forwardReason=' + forwardReason;
      
              // Send the form data to the server via AJAX
              $.ajax({
                  url: '{{ route("employee.query.action") }}', // Route for your action handler
                  method: 'POST',
                  data: formData, // Send the serialized form data (includes CSRF token automatically)
                  success: function (response) {
                      // Check if the response contains a success message
                      if (response.success) {
                          // Show success message above the form
                          $('#actionMessage')
                              .removeClass('alert-danger') // Remove any previous error class
                              .addClass('alert-success') // Add success class
                              .text(response.message) // Display the success message from server response
                              .show(); // Display the message
      
                          // Optionally, you can hide the modal after success
                          // $('#actionModal').modal('hide');
      
                          // Optionally, you can refresh the table or update the status here
                          // Example: $('#someTable').load(location.href + ' #someTable');
                      } else {
                          // Show error message if response indicates failure
                          $('#actionMessage')
                              .removeClass('alert-success') // Remove success class
                              .addClass('alert-danger') // Add error class
                              .text(response.message) // Display the failure message from server response
                              .show(); // Display the error message
                      }
                  },
                  error: function (xhr, status, error) {
                      console.log("Error saving action:", xhr.responseText);
      
                      // Show error message above the form in case of AJAX failure
                      $('#actionMessage')
                          .removeClass('alert-success') // Remove success class
                          .addClass('alert-danger') // Add error class
                          .text('An error occurred while saving the action. Please try again.') // Set error message
                          .show(); // Display error message
                  }
              });
          });
      
      });
      // When the modal is hidden (i.e., closed), reset the form and any messages.
      
      $(document).ready(function () {
          $('#actionModal').on('hidden.bs.modal', function () {
              location.reload(); // Reloads the page when the modal is closed
          });
      });
      
      $(document).ready(function() {
      // Handle star click to select multiple stars
      $('.star').on('click', function() {
      var queryId = $(this).data('query-id');  // Get the QueryId for the clicked star
      var rating = $(this).data('value');      // Get the value of the clicked star
      
      // Update the stars in the UI based on the clicked star
      $(this).siblings().removeClass('text-success').addClass('text-muted');
      $(this).prevAll().addClass('text-success');
      $(this).addClass('text-success');
      
      // Allow for the possibility of selecting multiple stars
      if ($(this).hasClass('text-muted')) {
          $(this).removeClass('text-muted').addClass('text-success');
      } else {
          $(this).addClass('text-muted').removeClass('text-success');
      }
      
      // Send the selected rating to the server via AJAX
      var selectedRating = 0;
      $(this).siblings().addBack().each(function() {
          if ($(this).hasClass('text-success')) {
              selectedRating++;
          }
      });
      
      // Send the selected rating to the server
      $.ajax({
          url: '/update-query-rating',  // Your route for handling the rating update
          type: 'POST',
          data: {
              queryId: queryId,
              rating: selectedRating,
              _token: '{{ csrf_token() }}'  // Include CSRF token for security
          },
          success: function(response) {
              // Show success or error message above the table based on the response
              var message = response.message;
              var messageType = response.success ? 'success' : 'error';
      
              // Clear any previous messages
              $('#message-container').html('');
              $('#message-container').html('<div class="alert alert-' + messageType + '">' + message + '</div>');
      
              // Update the rating in the current row (if necessary)
              if (response.success) {
                  // You could also update other elements here if needed
                  // Just update the current row with the new rating
                  updateRatingDisplay(queryId, selectedRating);
              }
      
              // Make the message disappear after 3 seconds
              setTimeout(function() {
                  $('#message-container').html('');
              }, 3000); // 3 seconds delay
          },
          error: function(xhr, status, error) {
              // Handle AJAX error
              $('#message-container').html('<div class="alert alert-danger">An error occurred while updating the rating.</div>');
              setTimeout(function() {
                  $('#message-container').html('');
              }, 3000); // 3 seconds delay
          }
      });
      });
      
    
    });
      
      // Function to update the rating display in the UI after the AJAX request
      function updateRatingDisplay(queryId, selectedRating) {
      // Find the row for the specific queryId
      var row = $('tr[data-query-id="' + queryId + '"]');
      
      // Update the star rating display for the row
      row.find('.star').each(function(index) {
      if (index < selectedRating) {
          $(this).removeClass('text-muted').addClass('text-success');
      } else {
          $(this).removeClass('text-success').addClass('text-muted');
      }
      });
      }
      
      
   </script>