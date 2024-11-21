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
                                                <th colspan="1">Status</th>
                                                <th colspan="2">Action</th>
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
                                                  @php
                                             $queryList = Auth::user()->queryMap;
                                             $departments = Auth::user()->departments->keyBy('DepartmentId'); // Key by DepartmentId for quick lookup
                                             @endphp
                                             <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Details</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <!-- <th>Level 2</th>
                                                <th>Level 3</th> -->
                                                <th>Action</th>
                                                @if($queryList->pluck('EmpQRating')->filter(function($rating) { return $rating > 0; })->isNotEmpty())
                                                      <th>Rating</th>
                                                @endif
                                             </tr>
                                          </thead>
                                          <tbody id="queryTableBody">
                                           
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
                                                      <span class="badge badge-pill {{ $query->QueryStatus_Emp === 3 ? 'bg-success' : 'bg-secondary' }} text-sm">
                                                         {{ $statusMap[$query->QueryStatus_Emp] ?? '-' }}
                                                      </span>
                                                   </td>

                                                         <td>
                                                            <!-- Take Action Button -->
                                                            @if($query->QueryStatus_Emp == 0 || $query->QueryStatus_Emp == 1)  <!-- Open or InProcess status -->
                                                            <button class="btn badge-warning btn-xs take-action-emp-btn" data-query-id="{{ $query->QueryId }}">
                                                               Action
                                                            </button>
                                                            @else
                                                            <button class="btn badge-secondary btn-xs take-action-emp-btn" data-query-id="{{ $query->QueryId }}">
                                                               Closed
                                                            </button>
                                                            @endif
                                                         </td>
                                                            <td>
                                                         @php
                                                            $rating = $query->EmpQRating ?? 0; // Default to 0 if no rating is provided
                                                         @endphp

                                                         <!-- Display stars based on the rating, only if QueryStatus_Emp is 3 -->
                                                         @if($query->QueryStatus_Emp == 3 && $rating > 0)
                                                            <span class="stars">
                                                                  @for ($i = 1; $i <= $rating; $i++) <!-- Loop only until the rating value -->
                                                                     <i class="fa fa-star text-success" 
                                                                        data-value="{{ $i }}" 
                                                                        data-query-id="{{ $query->QueryId }}" 
                                                                        style="cursor: pointer;"></i>
                                                                  @endfor
                                                            </span>
                                                         @endif
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
                  @csrf 
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
                     <option value="0" disabled selected>Select Status</option>
                        <option value="1">In Progress</option>
                        <option value="2">Reply</option>
                        <option value="4">Esclose</option>
                        <option value="3">Closed</option>
                     </select>
                  </div>
                  <div class="form-group">
                     <label for="reply">Reply Remark</label>
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

   <!-- Modal for displaying query details -->
   <div class="modal fade" id="queryDetailsModal" tabindex="-1" aria-labelledby="queryDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="queryDetailsModalLabel">Query Details</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <!-- Responsive table inside modal -->
                  <div class="table-responsive">
                     <table class="table table-bordered table-striped table-hover" style="table-layout: fixed;">
                           <thead class="thead-dark">
                           <thead class="thead-dark">
                              <tr>
                              <th style="width: 150px;">Sno.</th>
                                 <th style="width: 150px;">Date</th>
                                 <th style="width: 150px;">Subject</th>
                                 <th style="width: 150px;">Details</th>
                                 <th style="width: 150px;">Department</th>
                                 <th style="width: 150px;">Level 1 Status</th>
                                 <th style="width: 150px;">Level 1 Remark</th>
                                 <th style="width: 150px;">Level 2 Status</th>
                                 <th style="width: 150px;">Level 2 Remark</th>
                                 <th style="width: 150px;">Level 3 Status</th>
                                 <th style="width: 150px;">Level 3 Remark</th>
                                 <th style="width: 150px;">Status</th>
                                 <th style="width: 150px;">Remark</th>
                                 <th style="width: 150px;">Action</th>
                              </tr>
                           </thead>
                           </thead>
                           <tbody id="modalQueryDetails">
                              <!-- Data will be populated here via JavaScript -->
                           </tbody>
                     </table>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               </div>
         </div>
      </div>
   </div>

<!-- New Modal for Action -->
<div class="modal fade" id="actionModalEmp" tabindex="-1" aria-labelledby="actionModalEmpLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actionModalEmpLabel">Query Action</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div id="messageContainer" style="display: none;"></div>

                <form id="actionForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="actionStatus">Action Status</label>
                        <select id="actionStatus" class="form-control">
                        <option value="select" selected>Select Option </option>
                            <option value="0">ReOpen</option>
                            <option value="3">Close</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="actionRemark">Remark</label>
                        <textarea id="actionRemark" class="form-control" rows="4"></textarea>
                    </div>
                   <!-- Rating stars, initially hidden -->
                   <div class="form-group" id="ratingSection" style="display: none;">
                              <label for="rating">Rating (1 to 5)</label>
                              <select id="rating" class="form-control">
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                                 <option value="4">4</option>
                                 <option value="5">5</option>
                              </select>
                           </div>

                    <input type="hidden" id="actionQueryId" name="query_id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitAction">Submit</button>
            </div>
        </div>
    </div>
</div>


   @include('employee.footer');
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>       
         var options = @json($departments_sub); // Get subjects as a JSON array
         const deptQueryUrl = '/update-query-rating';
         const employeequery ="{{ route("employee.queries") }}";
         const deptqueriesub="{{ route("employee.deptqueriesub") }}";
         const queryaction="{{ route("employee.query.action") }}";

    </script>
		<script src="{{ asset('../js/dynamicjs/query.js/') }}" defer></script>
