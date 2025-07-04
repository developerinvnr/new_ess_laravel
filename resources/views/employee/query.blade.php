@include('employee.header')
<body class="mini-sidebar">
@include('employee.sidebar')

<div id="loader" style="display:none;">
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
                           <li class="breadcrumb-link active">Query</li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Dashboard Start -->
            
            <div class="row">
            <div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
               <div class="col-12">
               
                  <!-- Start of Tabs Section -->
                  <div class="nav-tabs-custom">
                     <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="queryTabs" role="tablist">
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
                                          <form id="queryForm" action="{{ route('querysubmit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="employee_id" value="{{ Auth::user()->EmployeeID }}">

                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <p style="color:#999;">CC to your reporting manager & HOD</p>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name" class="col-form-label"><b>Select Department
                                                        Name <span class="danger">*</span></b></label>
                                                <select class="select2 form-control select-opt" id="Department_name"
                                                    name="Department_name">
                                                    <option value="" disabled selected>Select Department</option>
                                                    

                                                    @foreach ($query_department_list as $department)
                                                        <option value="{{ $department->id }}">{{
                                                        $department->department_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="sel_arrow">
                                                    <i class="fa fa-angle-down"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                            <div class="form-group s-opt">
                                                <label for="Department_name_sub" class="col-form-label"><b>Select
                                                        Subject <span class="danger">*</span></b></label>
                                                <select class="select2 form-control select-opt" id="Department_name_sub"
                                                    name="Department_name_sub">
                                                    <option value="" disabled selected>Select Subject</option>
                                                  

                                                    @foreach ($departments_sub as $department_sub)
                                                        <option value="{{ $department_sub->DeptQSubject }}"
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

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="form-group">
                                                <!-- <label for="remarks" class="col-form-label"><b>Remarks</b></label> -->
                                                <textarea style="min-height:35px;" class="form-control" placeholder="Enter your remarks"
                                                    id="remarks" name="remarks"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="checkbox">
                                                <input id="checkbox3" type="checkbox" name="hide_name">
                                                <label for="checkbox3"
                                                    style="padding-top:4px;font-size:11px;color:#646262;">Do you want to
                                                    hide your name from Reporting
                                                    Manager & HOD?</label>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
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
                                       <div id="message-container"></div>
                                       <table class="table"  id="querylist">
                                       <thead class="thead-light" style="background-color:#f1f1f1; text-align: center;">
                                             <tr style="background-color:#ddd;">
                                                <th colspan="5">Query Details</th>
                                                <th colspan="1">Status</th>
                                                <th colspan="2">Self Action</th>
                                                <th></th>
                                                <th></th>

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
                                             //$queryList = Auth::user()->queryMap;
                                             @endphp
                                             <tr>
                                                <th>Sno.</th>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Details</th>
                                                <th>Department</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <th>View</th>

                                                @if($queryList->pluck('EmpQRating')->filter(function($rating) { return $rating > 0; })->isNotEmpty())
                                                      <th>Rating</th>
                                                @endif
                                                <th></th>
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
                                                @php
                                                   // Fetch the department record for the current query
                                                   $department = \DB::table('core_departments')->where('id', $query->QToDepartmentId)->first();
                                                @endphp

                                                <td>{{ $department->department_name ?? 'NA' }}</td>
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
                                                   @if(in_array($query->Mngmt_QStatus, [1, 2, 3, 4]))
                                                      <span class="badge badge-pill bg-secondary text-sm">
                                                            {{ $statusMap[$query->Mngmt_QStatus] ?? '-' }} (Management Level)
                                                      </span>
                                                   @endif
                                                </td>

                                                <td>
                                                  
                                                <!-- Delete Button if any of the levels is '0' (open) and not '3' (closed) -->
                                                @if($query->Level_1QStatus == 0 && $query->Level_2QStatus == 0 && $query->Level_3QStatus == 0)
                                                   <button class="btn badge-danger btn-xs soft-delete-btn" data-query-id="{{ $query->QueryId }}">
                                                      Delete
                                                   </button>
                                                @endif


                                                      <!-- Action Button Based on Levels -->
                                                      @if(in_array(3, [$query->Level_1QStatus, $query->Level_2QStatus, $query->Level_3QStatus,$query->Mngmt_QStatus]))
                                                         <!-- If any level has status 3 (closed), no action button should be shown -->
                                                         @if($query->QueryStatus_Emp != 3) 
                                                               <!-- If the query status is not closed (not 3) -->
                                                               <button class="btn badge-warning btn-xs take-action-emp-btn" data-query-id="{{ $query->QueryId }}" 
                                                                     data-query-status="{{ $query->QueryStatus_Emp }}" data-query-remark="{{ $query->QueryReply }}">
                                                                  Action
                                                               </button>
                                                         @endif
                                                         @if($query->QueryStatus_Emp == 3) 
                                                               <!-- If the query status is closed (3) -->
                                                               <button class="btn badge-warning btn-xs take-action-emp-btn" data-query-id="{{ $query->QueryId }}" 
                                                                     data-query-status="{{ $query->QueryStatus_Emp }}" data-query-remark="{{ $query->QueryReply }}">
                                                                  Closed
                                                               </button>
                                                         @endif
                                                      @else
                                                         <!-- If no level has status 3, show the action button but disable it -->
                                                         <!-- <button class="btn badge-secondary btn-xs take-action-emp-btn" disabled>
                                                               Action
                                                         </button> -->
                                                         @if($query->QueryStatus_Emp == 0) 
                                                               <!-- If the query status is closed (3) -->
                                                               <button class="btn badge-secondary btn-xs take-action-emp-btn" disabled>
                                                                  Action
                                                               </button>
                                                         @endif
                                                      @endif
                                                </td>
                                                <td>
                                                <button type="button" class="btn badge-primary btn-xs" onclick="showQueryDetails('{{ $query->QueryId }}')">View</button>

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
                                        <!-- Pagination links styled with Bootstrap -->
                                        <div class="pagination-wrapper mt-4">
                                          <div class="d-flex justify-content-end">
                                             {{ $queryList->links('pagination::bootstrap-4') }} <!-- Ensure it uses Bootstrap 4 style -->
                                          </div>
                                       </div>
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
                                       <div>
                                          
                                          <select id="statusFilter" style="float:right;">
                                             <option value="">All</option>
                                             <option value="0">Open</option>
                                             <option value="1">In Progress</option>
                                             <option value="2">Reply</option>
                                             <option value="3">Closed</option>
                                             <option value="4">Forward</option>
                                          </select>
                                          @if(Auth::user()->EmployeeID == 1707 || Auth::user()->EmployeeID == 1763 )
                                          <select id="subjectFilter" style="float:right; margin-right: 10px;">
                                             <option value="">Subjects</option>
                                             <option value="Ledger Confirmation">Ledger Confirmation</option>
                                          </select>
                                          @endif

                                       </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                       <table class="table" id="employeeQueryListTable">
                                          <thead class="thead-light" style="background-color:#f1f1f1;">
                                             <tr style="background-color:#ddd;">
                                                <th>Sno.</th>
                                                <th>EC</th>
                                                <th>Employee Name</th>
                                                <th>Query Requested At</th>
                                                <th>Query Details</th>
                                                <th>Employee Status</th>
                                                <th>Level 1Status</th>
                                                <th style="width: 150px;">Level 1 Ldate</th>
                                                <th>Level 2 Status</th>
                                                <th>Level 3 Status</th>
                                            
                                                <th>Management Action</th>
                                                <th>Take Action</th>
                                                <th>View</th>
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
                                                <th>EC</th>
                                                <th>Employee Name</th>
                                                <th>Query Requested At</th>
                                                <th>Query Details</th>
                                                <th>Employee Status</th>
                                                <th>Level 1 Status</th>
                                                <th>Level 2 Status</th>
                                                <th>Level 3 Status</th>
                                                <th>Management Action</th>
                                                <th>View</th>
                                                </tr>
                                          </thead>
                                          <tbody id="newTabTableBody">
                                                @foreach($queries_frwrd as $index => $query)
                                                @php
                                                
                                                $forwardedEmpIds = $query->pluck('Level_1QFwdEmpId')->filter()->unique();

                                                // Fetch employee details for all these IDs
                                                $forwardedEmployees = DB::table('hrm_employee')
                                                   ->whereIn('EmployeeID', $forwardedEmpIds)
                                                   ->select('EmployeeID', 'Fname', 'Sname', 'Lname')
                                                   ->get()
                                                   ->keyBy('EmployeeID'); // So you can access by ID easily
                                                @endphp
                                                   <tr>
                                                      <td>{{ $index + 1 }}</td>
                                                      <td>{{$employeeNames[$query->EmployeeID]->EmpCode}}</td>
                                                      <td>{{ $employeeNames[$query->EmployeeID]->Fname }} {{ $employeeNames[$query->EmployeeID]->Sname }} {{ $employeeNames[$query->EmployeeID]->Lname }}</td>
                                                      <td>
                                                            <strong>Subject:</strong> {{ $query->QuerySubject }} <br>
                                                            <strong>Subject Details:</strong> {{ $query->QueryValue }} <br>
                                                            <strong>Forwarded To:</strong>
                                                            {{ $forwardedEmployees[$query->Level_1QFwdEmpId]->Fname ?? '' }}
                                                            {{ $forwardedEmployees[$query->Level_1QFwdEmpId]->Sname ?? '' }}
                                                            {{ $forwardedEmployees[$query->Level_1QFwdEmpId]->Lname ?? '' }}
                                                            </td>
                                                            <td>{{ \Carbon\Carbon::parse($query->QueryDT)->format('j F Y') }}</td>

                                                            @if($query->QueryStatus_Emp != "")
                                                                  <td>
                                                                     @if($query->QueryStatus_Emp == 1)
                                                                     <b class='warning'>In Progress</b>
                                                                     @elseif($query->QueryStatus_Emp == 2)
                                                                     <b class='info'>Reply</b>
                                                                     @elseif($query->QueryStatus_Emp == 3)
                                                                     <b class='deafult'>Closed</b>
                                                                     @elseif($query->QueryStatus_Emp == 4)
                                                                     <b class='danger'>Forwarded</b>
                                                                     @elseif($query->QueryStatus_Emp == 0)
                                                                     <b class='success'>Open</b>
                                                                     @endif
                                                                  </td>
                                                            @endif

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
                                                          <td>
                                                <button type="button" class="btn badge-primary btn-xs" onclick="showQueryDetails('{{ $query->QueryId }}')">View</button>

                                             </td>
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
                  <div class="form-group mb-0">
                     <label for="queryName"><b>Name</b></label>
                     <input type="text" id="queryName" class="form-control" name="queryName" readonly>
                  </div>
                  <div class="form-group mb-0">
                     <label for="querySubject"><b>Subject</b> </label>
                     <input type="text" id="querySubject" class="form-control" name="querySubject">
                  </div>
                  <div class="form-group mb-0">
                     <label for="querySubjectValue"><b>Subject Details</b></label>
                     <input type="text" id="querySubjectValue" class="form-control" name="querySubjectValue"
                        readonly>
                  </div>
                 <div id="remarksDisplay" class="form-control-plaintext mb-1"></div>

                  
                  <!-- <div class="form-group mb-0">
                     <label for="queryDepartment"><b>Query Department</b></label>
                     <input type="text" id="queryDepartment" class="form-control" name="queryDepartment"
                        readonly>
                  </div> -->
                  <div class="form-group s-opt">
                        <label for="status"><b>Status</b></label>

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
                        <!-- <i id="status-loader" class="fas fa-sync-alt" style="cursor: pointer;"></i> -->
                     
                        </div>

                  <div class="form-group"id="replyremark" style="display:none;">
                     <label for="reply"><b> Remark</b> </label>
                     <textarea id="reply" class="form-control" name="reply" rows="3"></textarea>
                     <!-- <span id="reply_span" class="form-control" name="reply_span" rows="3" style="display:none;"></s> -->

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
   
   <!-- Modal query details -->
   <div id="viewqueryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewqueryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="viewqueryModalLabel">Query Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="query-request-box">
                  <div class="query-req-section">
                     <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                        <span class="float-start"><b>Dept.: </b><span id="modalDept"></span></span>
                        <span class="float-end"><b>Sub: </b><span id="modalSub"></span></span>
                     </div>
                     <div class="mb-2"><p id="modalQueryDetails"> </p></div>
                     <div class="w-100" style="font-size:11px;">
                        <span class="me-3"><b>Raise on:</b> <span id="modalRaiseDate"></span></span>
                        <span class="me-3" style="float:right;"><span id="modalRating" class="stars"></span></span>

                     </div>
                  </div>
               </div>

               <!-- Level 1 -->
               <div class="level-box-1 mb-3">
                  <div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
                     <span class="float-start"><b>Level 1</b></span>
                  </div>
                  <div class="mb-2">
                     <span><small><b>Status:</b> <span id="level1Status"></span></small></span>
                     <span class="float-end"><small><span id="level1Date"></span></small></span>
                     <p><b>Remarks:</b> <span id="level1Remarks"></span></p>
                  </div>
               </div>

               <!-- Level 2 -->
               <div class="level-box-2 mb-3">
                  <div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
                     <span class="float-start"><b>Level 2</b></span>
                  </div>
                  <div class="mb-2">
                     <span><small><b>Status:</b> <span id="level2Status"></span></small></span>
                     <span class="float-end"><small><span id="level2Date"></span></small></span>
                     <p><b>Remarks:</b> <span id="level2Remarks"></span></p>
                  </div>
               </div>

               <!-- Level 3 -->
               <div class="level-box-3 mb-3">
                  <div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
                     <span class="float-start"><b>Level 3</b></span>
                  </div>
                  <div class="mb-2">
                     <span><small><b>Status:</b> <span id="level3Status" ></span></small></span>
                     <span class="float-end"><small><span id="level3Date"></span></small></span>
                     <p><b>Remarks:</b> <span id="level3Remarks"></span></p>
                  </div>
               </div>
               <div class="level-box-3 mb-3">
                  <div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
                     <span class="float-start"><b>Management Level</b></span>
                  </div>
                  <div class="mb-2">
                     <span><small><b>Status:</b> <span id="mangStatus" ></span></small></span>
                     <span class="float-end"><small><span id="mangDate"></span></small></span>
                     <p><b>Remarks:</b> <span id="mangRemarks"></span></p>
                  </div>
               </div>
               {{-- Employee Level --}}
                <div class="level-box-3 mb-3">
                  <div class="float-start w-100 pb-1 mb-1" style="border-bottom:1px solid #ddd;">
                     <span class="float-start"><b>Employee</b></span>
                  </div>
                  <div class="mb-2">
                     <span><small><b>Status:</b> <span id="empStatus" ></span></small></span>
                     <span class="float-end"><small><span id="empDate"></span></small></span>
                     <p><b>Remarks:</b> <span id="empRemarks"></span></p>
                  </div>
               </div>
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
 
    <script>       
         var options = @json($departments_sub); // Get subjects as a JSON array
         const deptQueryUrl = '/update-query-rating';
         const employeequery ="{{ route("employee.queries") }}";
         const deptqueriesub="{{ route("employee.deptqueriesub") }}";
         const queryaction="{{ route("employee.query.action") }}";
         const employeeId = {{ Auth::user()->EmployeeID }};

    </script>
    <script>
   
   $(document).ready(function () {
    var table = $('#employeeQueryListTable').DataTable({
        paging: true,               // Enable pagination
        pageLength: 10,             // Number of rows per page
        lengthMenu: [5, 10, 25, 50, 100], // Options for rows per page
        searching: true,            // Enable searching
        ordering: false,            // Enable column sorting
        info: true,                 // Show table information (e.g., page numbers)
        responsive: true,           // Enable responsive feature for mobile
        scrollCollapse: true,       // Allow the table to collapse when there are fewer rows
        fixedHeader: true,          // Fix the header while scrolling
        autoWidth: false,           // Prevent DataTables from automatically adjusting column widths
        columnDefs: [
            {
                targets: [4, 5], // Apply wrapping to the Query Details and Employee Status columns
                createdCell: function (td, cellData, rowData, row, col) {
                    // Prevents long content from expanding the row height
                    $(td).css({
                        'word-wrap': 'break-word',
                        'white-space': 'normal',
                        'overflow': 'hidden',
                        'text-overflow': 'ellipsis',
                        'font-family': 'Roboto, sans-serif'  // Ensure the font is applied to specific cells

                    });
                }
            }
        ]
   
      });

   // Apply Roboto font to the entire DataTable (header and body)
   $('#employeeQueryListTable').css('font-family', 'Roboto, sans-serif');
    $('#employeeQueryListTable').find('th, td').css('font-family', 'Roboto, sans-serif');
//     $('#statusFilter').on('change', function() {
//     var selectedValue = $(this).val(); // Get the selected filter value
//     var statusMap = {
//         '0': 'Open',
//         '1': 'In Progress',
//         '2': 'Reply',
//         '3': 'Closed',
//         '4': 'Forward'
//     };

//     if (selectedValue === "") {
//         // If "All" is selected, reset the search on all columns
//         table.columns(9).search('').draw();
//     } else {
//         // Apply the search filter across relevant columns (Employee Status, Level 1, Level 2, Level 3, Management Action)
//         table.columns(9).search(statusMap[selectedValue] || '').draw();
//     }
// });

   
   });

$(document).ready(function () {
    var table = $('#newTabTable').DataTable({
        paging: true,               // Enable pagination
        pageLength: 10,             // Number of rows per page
        lengthMenu: [5, 10, 25, 50, 100], // Options for rows per page
        searching: true,            // Enable searching
        ordering: false,            // Enable column sorting
        info: true,                 // Show table information (e.g., page numbers)
        responsive: true,           // Enable responsive feature for mobile
        scrollCollapse: true,       // Allow the table to collapse when there are fewer rows
        fixedHeader: true,          // Fix the header while scrolling
        autoWidth: false, 
        columnDefs: [
            {
                targets: [4, 5], // Apply wrapping to the Query Details and Employee Status columns
                createdCell: function (td, cellData, rowData, row, col) {
                    // Prevents long content from expanding the row height
                    $(td).css({
                        'word-wrap': 'break-word',
                        'white-space': 'normal',
                        'overflow': 'hidden',
                        'text-overflow': 'ellipsis',
                        'font-family': 'Roboto, sans-serif'  // Ensure the font is applied to specific cells

                    });
                }
            }
        ]
    
      });
      $('#newTabTable').css('font-family', 'Roboto, sans-serif');
    $('#newTabTable').find('th, td').css('font-family', 'Roboto, sans-serif');


   });
 
    function populateRating(rating) {
         const ratingContainer = document.getElementById('modalRating');
         if (!ratingContainer) return;
         if (!rating || rating === 0) {
                     return;
                  }
       
         ratingContainer.innerHTML = '';

      
     
               for (let i = 1; i <= 5; i++) {
                  const star = document.createElement('i');
                  star.classList.add('fa', 'fa-star');
                  if (i <= rating) {
                        star.classList.add('text-success'); // Filled star
                  } else {
                        star.classList.add('text-muted');  // Unfilled star
                  }
                  star.setAttribute('style', 'cursor: pointer;');
                  star.setAttribute('data-value', i);
                  ratingContainer.appendChild(star);
         }
      }
 function showQueryDetails(queryId) {
      $.ajax({
         url: `/query-details/${queryId}`, // This route matches the one defined in web.php
         type: 'GET',
         data: { queryId: queryId },
         success: function(response) {
            console.log(response);
               // Populate the modal with data from the response
               document.getElementById('modalDept').innerText = response.data.dept;
               document.getElementById('modalSub').innerText = response.data.subject;
               document.getElementById('modalQueryDetails').innerText = response.data.details;
               document.getElementById('modalRaiseDate').innerText = formatDateddmmyyyy(response.data.raiseDate);
               document.getElementById('level1Status').innerText = response.data.level1Status;

               // Add corresponding class based on the status
               var statusClass = '';  // Default class

               // Set class based on the status value
               switch(response.data.level1Status) {
                  case 'In Progress':
                     statusClass = 'warning';  // Class for "In Progress"
                     break;
                  case 'Reply':
                     statusClass = 'info';  // Class for "Reply"
                     break;
                  case 'Closed':
                     statusClass = 'danger';  // Class for "Closed"
                     break;
                  case 'Open':
                     statusClass = 'success';  // Class for "Open"
                     break;
                  case 'Forwarded':
                     statusClass = 'primary';  // Class for "Forwarded"
                     break;
                  default:
                     statusClass = '';  // No class if status is unknown
               }

               // Apply the class to the element
               document.getElementById('level1Status').className = statusClass;
               document.getElementById('level1Date').innerText = formatDateddmmyyyy(response.data.level1Date);
               document.getElementById('level1Remarks').innerText = response.data.level1Remarks;
               document.getElementById('level2Status').innerText = response.data.level2Status;

               // Add corresponding class based on the level2Status value
               var statusClass2 = '';  // Default class

               // Set class based on the status value for level 2
               switch(response.data.level2Status) {
                  case 'In Progress':
                     statusClass2 = 'warning';  // Class for "In Progress"
                     break;
                  case 'Reply':
                     statusClass2 = 'info';  // Class for "Reply"
                     break;
                  case 'Closed':
                     statusClass2 = 'danger';  // Class for "Closed"
                     break;
                  case 'Open':
                     statusClass2 = 'success';  // Class for "Open"
                     break;
                  case 'Forwarded':
                     statusClass2 = 'primary';  // Class for "Forwarded"
                     break;
                  default:
                     statusClass2 = '';  // No class if status is unknown
               }

               // Apply the class to the element
               document.getElementById('level2Status').className = statusClass2;
               document.getElementById('level2Date').innerText = formatDateddmmyyyy(response.data.level2Date);
               document.getElementById('level2Remarks').innerText = response.data.level2Remarks;
               document.getElementById('level3Status').innerText = response.data.level3Status;

               // Add class based on the status
               let level3StatusClass = '';
               switch (response.data.level3Status) {
                  case 'Open':
                     level3StatusClass = 'success'; // You can define your own CSS class for 'Open'
                     break;
                  case 'In Progress':
                     level3StatusClass = 'warning'; // Define your own CSS class for 'In Progress'
                     break;
                  case 'Reply':
                     level3StatusClass = 'info'; // Define your own CSS class for 'Reply'
                     break;
                  case 'Closed':
                     level3StatusClass = 'danger'; // Define your own CSS class for 'Closed'
                     break;
                  case 'Forwarded':
                     level3StatusClass = 'primary'; // Define your own CSS class for 'Forwarded'
                     break;
                  default:
                     level3StatusClass = ''; // A default class in case the status is unknown
                     break;
               }

               // Apply the class to the element
               document.getElementById('level3Status').classList.add(level3StatusClass);
               document.getElementById('level3Date').innerText = formatDateddmmyyyy(response.data.level3Date);
               document.getElementById('level3Remarks').innerText = response.data.level3Remarks;
               document.getElementById('mangStatus').innerText = response.data.mangStatus;

               // Add class based on the status
               let mangStatusClass = '';
               switch (response.data.mangStatus) {
                  case 'Open':
                     mangStatusClass = 'success'; // Define your own CSS class for 'Open'
                     break;
                  case 'In Progress':
                     mangStatusClass = 'warning'; // Define your own CSS class for 'In Progress'
                     break;
                  case 'Reply':
                     mangStatusClass = 'info'; // Define your own CSS class for 'Reply'
                     break;
                  case 'Closed':
                     mangStatusClass = 'danger'; // Define your own CSS class for 'Closed'
                     break;
                  case 'Forwarded':
                     mangStatusClass = 'primary'; // Define your own CSS class for 'Forwarded'
                     break;
                  default:
                     mangStatusClass = ''; // Default class in case the status is unknown
                     break;
               }

               // Apply the class to the element
               document.getElementById('mangStatus').classList.add(mangStatusClass);
               document.getElementById('mangDate').innerText = formatDateddmmyyyy(response.data.mangDate);
               document.getElementById('mangRemarks').innerText = response.data.mangRemarks;
               document.getElementById('empStatus').innerText = response.data.EmpStatus;
               document.getElementById('empDate').innerText = formatDateddmmyyyy(response.data.raiseDate);
               document.getElementById('empRemarks').innerText = response.data.EmpRemarks;
               populateRating(response.data.Rating); 

               // Open the modal
               $('#viewqueryModal').modal('show');
         },
         error: function(xhr, status, error) {
               alert('Error fetching query details');
         }
      });
   }
   function formatDateddmmyyyy(date) {
            const d = new Date(date);
            const day = String(d.getDate()).padStart(2, '0');  // Ensures two digits for day
            const month = String(d.getMonth() + 1).padStart(2, '0');  // Ensures two digits for month
            const year = d.getFullYear();
            return `${day}-${month}-${year}`;  // Format as dd-mm-yyyy
        }

      // Ensure that when the page loads, the subject dropdown is empty
      document.addEventListener('DOMContentLoaded', function () {
        var subjectSelect = document.getElementById('Department_name_sub');
        subjectSelect.innerHTML = '<option value="" disabled selected>Select Subject</option>'; // Default empty state
    });

    // Event listener for Department selection change
    document.getElementById('Department_name').addEventListener('change', function () {
        var selectedDepartmentId = this.value; // Get selected department ID
        var subjectSelect = document.getElementById('Department_name_sub');
        
        // Clear current subjects (and reset the default option)
        subjectSelect.innerHTML = '<option value="" disabled selected>Select  Subject</option>';
        
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
    
    $(document).ready(function() {
         $('.soft-delete-btn').on('click', function() {
            var queryId = $(this).data('query-id');  // Get the query ID from the data attribute
            deleteQuery(queryId);  // Call the deleteQuery function
         });
      });

    function deleteQuery(queryId) {
    // Confirm before deleting
    if (confirm('Are you sure you want to delete this query?')) {
        // Send AJAX request to delete the query
        $.ajax({
            url: '/delete-query/' + queryId,  // URL for deleting query (adjust the route accordingly)
            type: 'DELETE',  // HTTP method for deletion
            data: {
                "_token": "{{ csrf_token() }}",  // CSRF token for security
            },
            success: function(response) {
                // Show a success toast notification
                toastr.success(response.message, 'Success', {
                  "positionClass": "toast-top-right",  // Position it at the top right of the screen
                  "timeOut": 5000  // Duration for which the toast is visible (in ms)
               });

               // Reload the page after the toast
               setTimeout(function() {
                  location.reload();
               }, 5000);  // Delay the reload to match the timeOut value of the toast (5000ms)
                              
                // Optionally, remove the query row from the table or update UI accordingly
                $('#query-row-' + queryId).remove();  // Assuming each query row has an id in the format `query-row-<queryId>`
            },
            error: function(xhr, status, error) {
                // Show an error toast notification
                toastr.error('An error occurred while processing the deletion.', 'Error', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
            }
        });
    }
}




</script>

		<script src="{{ asset('../js/dynamicjs/query.js/') }}" defer></script>
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
.dataTables_wrapper table.dataTable td{
  border: none !important;
  font-family: roboto;
}
      </style>
