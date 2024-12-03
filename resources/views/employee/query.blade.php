@include('employee.head')
@include('employee.header')
@include('employee.sidebar')
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
                        
                        @if($queries_frwrd->isNotEmpty()) 
                           <!-- Only display the nav item if there are forwarded queries -->
                           <li class="nav-item">
                              <a style="color: #0e0e0e;" id="newTab" class="nav-link"
                                    data-bs-toggle="tab" href="#newTabSection" role="tab"
                                    aria-controls="newTabSection" aria-selected="false">Forwarded Queries</a>
                           </li>
                        @endif

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
                                                         class="col-form-label"><b>Select Department <span class="danger">*</span></b></label>
                                                      <select class="select2 form-control select-opt"
                                                         id="Department_name" name="Department_name">
                                                         <option value="" disabled selected>Select 
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
                                                         class="col-form-label"><b>Select Subject <span class="danger">*</span></b></label>
                                                      <select class="select2 form-control select-opt"
                                                         id="Department_name_sub"
                                                         name="Department_name_sub">
                                                         <option value="" disabled selected>Select 
                                                            subject
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
                                                         placeholder="Enter remarks"
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
                                                      <!-- Loader next to the submit button (initially hidden) -->
                                                      <span id="loader" style="display: none;">
                                                         <i class="fa fa-spinner fa-spin"></i> <!-- You can use a spinner icon from FontAwesome or any custom loader -->
                                                      </span>
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
                                                      1 => 'InProcess',
                                                      2 => 'Reply',
                                                      3 => 'Close',
                                                      4 => 'Forward',
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
                                                   <!-- Display Level Statuses -->
                                                   @if(in_array($query->Level_1QStatus, [1, 2, 3, 4]))
                                                      <span class="badge badge-pill bg-secondary text-sm">
                                                            {{ $statusMap[$query->Level_1QStatus] ?? '-' }} (Level 1)
                                                      </span>
                                                   @endif

                                                   @if(in_array($query->Level_2QStatus, [1, 2, 3, 4]))
                                                      <span class="badge badge-pill bg-secondary text-sm">
                                                            {{ $statusMap[$query->Level_2QStatus] ?? '-' }} (Level 2)
                                                      </span>
                                                   @endif

                                                   @if(in_array($query->Level_3QStatus, [1, 2, 3, 4]))
                                                      <span class="badge badge-pill bg-secondary text-sm">
                                                            {{ $statusMap[$query->Level_3QStatus] ?? '-' }} (Level 3)
                                                      </span>
                                                   @endif
                                                </td>

                                                <td>
                                                      <!-- Action Button Based on Levels -->
                                                      @if(in_array(3, [$query->Level_1QStatus, $query->Level_2QStatus, $query->Level_3QStatus]))  <!-- No level is closed (not 3) -->
                                                         @if($query->QueryStatus_Emp != 3)  <!-- Query status is not closed -->
                                                         <button class="btn badge-warning btn-xs take-action-emp-btn" data-query-id="{{ $query->QueryId }}" data-query-status="{{ $query->QueryStatus_Emp }}"  data-query-remark="{{ $query->QueryReply }}">
                                                         Action
                                                               </button>
                                                         
                                                         @endif
                                                         @if($query->QueryStatus_Emp == 3)  <!-- Query status is not closed -->
                                                               <button class="btn badge-warning btn-xs take-action-emp-btn" data-query-id="{{ $query->QueryId }}" data-query-status="{{ $query->QueryStatus_Emp }}"  data-query-remark="{{ $query->QueryReply }}">
                                                                  Closed
                                                               </button>
                                                         
                                                         @endif
                                                      @else
                                                         <!-- No action button if any level has status 3 -->
                                                         <button class="btn badge-secondary btn-xs take-action-emp-btn" disabled>
                                                         Action
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
                                       <h4 class="card-title">Employee Queries</h4>
                                    </div>
                                    <div class="card-body table-responsive">
                                       <table class="table" id="employeeQueryListTable">
                                          <thead class="thead-light" style="background-color:#f1f1f1;">
                                             <tr style="background-color:#ddd;">
                                                <th>Sno.</th>
                                                <th>Employee Details</th>
                                                <th>Query Details</th>
                                                <th>Employee Status</th>
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

                        <!-- New frowarded Tab Section -->
                        @if($queries_frwrd->isNotEmpty()) 
                           <!-- Only display the tab if queries_frwrd is not empty -->
                           <div class="tab-pane fade" id="newTabSection" role="tabpanel" aria-labelledby="newTab">
                              <!-- New Tab Content -->
                              <div class="card">
                                    <div class="card-header pb-0">
                                       <h4 class="card-title">Forwarded Queries</h4>
                                    </div>
                                    <div class="card-body table-responsive">
                                       <table class="table" id="newTabTable">
                                          <thead class="thead-light" style="background-color:#f1f1f1;">
                                                <tr style="background-color:#ddd;">
                                                   <th>Sno.</th>
                                                   <th>Employee Details</th>
                                                   <th>Query Subject</th>
                                                   <th>Level 1 Status</th>
                                                   <th>Level 2 Status</th>
                                                   <th>Level 3 Status</th>
                                                   <th>Management Action</th>
                                                </tr>
                                          </thead>
                                          <tbody id="newTabTableBody">
                                                @foreach($queries_frwrd as $index => $query)
                                                   <tr>
                                                      <td>{{ $index + 1 }}</td>
                                                      <td>{{ $employeeNames[$query->EmployeeID]->Fname }} {{ $employeeNames[$query->EmployeeID]->Sname }} {{ $employeeNames[$query->EmployeeID]->Lname }}</td>
                                                      <td>
                                                            <strong>Subject:</strong> {{ $query->QuerySubject }} <br>
                                                            <strong>Subject Details:</strong> {{ $query->QueryValue }} <br>
                                                            <strong>Query to:</strong> {{ $departments[$query->QToDepartmentId]->DepartmentName ?? 'N/A' }} <br>
                                                            </td>
                                                      @if($query->Level_1QStatus != "")
                                                            <td>
                                                               @if($query->Level_1QStatus == 1)
                                                               <b class='warning'>In Progress</b>
                                                               @elseif($query->Level_1QStatus == 2)
                                                               <b class='info'>Reply</b>
                                                               @elseif($query->Level_1QStatus == 3)
                                                               <b class='deafult'>Closed</b>
                                                               @elseif($query->Level_1QStatus == 4)
                                                               <b class='danger'>Forwarded</b>
                                                               @elseif($query->Level_1QStatus == 0)
                                                               <b class='success'>Open</b>
                                                               @endif
                                                            </td>
                                                      @endif

                                                      @if($query->Level_2QStatus != "")
                                                            <td>
                                                               @if($query->Level_2QStatus == 1)
                                                               <b class='warning'>In Progress</b>
                                                               @elseif($query->Level_2QStatus == 2)
                                                               <b class='info'>Reply</b>
                                                               @elseif($query->Level_2QStatus == 3)
                                                               <b class='deafult'>Closed</b>
                                                               @elseif($query->Level_2QStatus == 4)
                                                               <b class='danger'>Forwarded</b>
                                                               @elseif($query->Level_2QStatus == 0)
                                                               <b class='success'>Open</b>
                                                               @endif
                                                            </td>
                                                      @endif

                                                      @if($query->Level_3QStatus != "")
                                                            <td>
                                                               @if($query->Level_3QStatus == 1)
                                                               <b class='warning'>In Progress</b>
                                                               @elseif($query->Level_3QStatus == 2)
                                                               <b class='info'>Reply</b>
                                                               @elseif($query->Level_3QStatus == 3)
                                                               <b class='deafult'>Closed</b>
                                                               @elseif($query->Level_3QStatus == 4)
                                                               <b class='danger'>Forwarded</b>
                                                               @elseif($query->Level_3QStatus == 0)
                                                               <b class='success'>Open</b>
                                                               @endif
                                                            </td>
                                                      @endif
                                                      @if($query->Mngmt_ID != "")
                                                               <td>
                                                                  @if($query->Mngmt_ID == 1)
                                                                  <b class='warning'>In Progress</b>
                                                                  @elseif($query->Mngmt_ID == 2)
                                                                  <b class='info'>Reply</b>
                                                                  @elseif($query->Mngmt_ID == 3)
                                                                  <b class='deafult'>Closed</b>
                                                                  @elseif($query->Mngmt_ID == 4)
                                                                  <b class='danger'>Forwarded</b>
                                                                  @elseif($query->Mngmt_ID == 0)
                                                                  <b class='success'>Open</b>
                                                                  @endif
                                                               </td>
                                                         @endif
                                                   </tr>
                                                @endforeach
                                          </tbody>
                                       </table>
                                    </div>
                              </div>
                           </div>
                        @else
                           <!-- If no queries, display nothing (the tab will not be shown) -->
                        @endif


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
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
                     <label for="querySubject">Subject </label>
                     <input type="text" id="querySubject" class="form-control" name="querySubject">
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
                  <div class="form-group s-opt">
                        <label for="status">Status</label>

                        <div class="status-dropdown-wrapper">
                           <select id="status" class="select2 form-control select-opt" name="status">
                              <option value="0" disabled selected>Select Status</option>
                              <option value="1">In Progress</option>
                              <option value="2">Reply</option>
                              <option value="4">Forward</option>
                              <option value="3" style="display: none;">Closed</option> <!-- Closed hidden initially -->
                           </select>
                           
                           <span class="sel_arrow">
                              <i class="fa fa-angle-down"></i>
                          </span>
                        </div>
                        <i id="status-loader" class="fas fa-sync-alt" style="cursor: pointer;"></i>
                     
                        </div>

                  <div class="form-group"id="replyremark" style="display:none;">
                     <label for="reply">Remark </label>
                     <textarea id="reply" class="form-control" name="reply" rows="3"></textarea>
                  </div>
                  <!-- Forward To & Forward Reason section (Initially hidden) -->
                  <div class="form-group s-opt" id="forwardSection" style="display:none;">
                     <label for="forwardTo">Forward To</label>
                     <select id="forwardTo" class="select2 form-control select-opt" name="forwardTo">
                        <option value="0">Select a Forward To</option>
                        <!-- Default option with value 0 -->
                     </select>
                     <span class="sel_arrow">
                        <i class="fa fa-angle-down"></i>
                    </span>
                  </div>
                  <div class="form-group" id="forwardReasonSection" style="display:none;">
                     <label for="forwardReason">Forward Reason</label>
                     <textarea id="forwardReason" class="form-control" name="forwardReason" rows="3"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade show" id="billdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
      style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
      <div class="modal-dialog modal-md modal-dialog-centered">
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
    <div class="modal-dialog modal-md modal-dialog-centered">
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
                    <div class="form-group s-opt">
                           <label for="actionStatus">Action Status</label>
                           <select id="actionStatus" class="select2 form-control select-opt">
                              <option value="" disabled selected>Select Option</option> <!-- Keep it disabled if you want to force selection -->
                              <option value="0">ReOpen</option>
                              <option value="3">Close</option>
                           </select>
                           <span class="sel_arrow">
                              <i class="fa fa-angle-down"></i>
                          </span>
                        </div>

                    <div class="form-group">
                        <label for="actionRemark">Remark</label>
                        <textarea id="actionRemark" class="form-control" rows="4"></textarea>
                    </div>
                   <!-- Rating stars, initially hidden -->
                   <div class="form-group s-opt" id="ratingSection" style="display: none;">
                              <label for="rating">Rating (1 to 5)</label>
                              <select id="rating" class="select2 form-control select-opt">
                                 <option value="1">1</option>
                                 <option value="2">2</option>
                                 <option value="3">3</option>
                                 <option value="4">4</option>
                                 <option value="5">5</option>
                              </select>
                              <span class="sel_arrow">
                                 <i class="fa fa-angle-down"></i>
                             </span>
                           </div>

                    <input type="hidden" id="actionQueryId" name="query_id">
                </form>
            </div>
            <div class="modal-footer">
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
         const employeeId = {{ Auth::user()->EmployeeID }};

    </script>
    <script>
   //  document.getElementById('Department_name').addEventListener('change', function () {
   //      var selectedDepartmentId = this.value; // Get selected department ID
   //      var subjectSelect = document.getElementById('Department_name_sub');
        
   //      // Clear current subjects
   //      subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
        
   //      // Get the departments' subjects from the Blade view
   //      var department_sub = @json($departments_sub);  // Blade variable passed as JSON
        
   //      // Filter subjects based on selected department
   //      department_sub.forEach(function (department_sub_item) {
   //          if (department_sub_item.DepartmentId == selectedDepartmentId) {
   //              var option = document.createElement('option');
   //              option.value = department_sub_item.DeptQSubject;
   //              option.text = department_sub_item.DeptQSubject;
   //              subjectSelect.appendChild(option); // Add the subject option to the dropdown
   //          }
   //      });
   //  });
      // Ensure that when the page loads, the subject dropdown is empty
      document.addEventListener('DOMContentLoaded', function () {
        var subjectSelect = document.getElementById('Department_name_sub');
        subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>'; // Default empty state
    });

    // Event listener for Department selection change
    document.getElementById('Department_name').addEventListener('change', function () {
        var selectedDepartmentId = this.value; // Get selected department ID
        var subjectSelect = document.getElementById('Department_name_sub');
        
        // Clear current subjects (and reset the default option)
        subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
        
        // If a department is selected, populate the subjects
        if (selectedDepartmentId) {
            // Get the departments' subjects from the Blade view
            var department_sub = @json($departments_sub);  // Blade variable passed as JSON
            
            // Filter subjects based on selected department
            department_sub.forEach(function (department_sub_item) {
                if (department_sub_item.DepartmentId == selectedDepartmentId) {
                    var option = document.createElement('option');
                    option.value = department_sub_item.DeptQSubject;
                    option.text = department_sub_item.DeptQSubject;
                    subjectSelect.appendChild(option); // Add the subject option to the dropdown
                }
            });
        }
    });

</script>

		<script src="{{ asset('../js/dynamicjs/query.js/') }}" defer></script>
