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
                           <li class="breadcrumb-link active">My Team - Attendance & Leave</li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Dashboard Start -->
            @include('employee.menuteam')
            <!-- Revanue Status Start -->
            <div class="row">
               <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                  <div class="card ad-info-card-">
                     <div class="card-header">
                        <h5 class="float-start mt-1"><b>Team Daily Reports</b></h5>
                     </div>
                     <!-- Filter Form -->
                     <div class="card-body pt-2 pb-0">
                           <!-- Month Filter -->
                        <form method="GET" action="{{ url()->current() }}" class="d-flex justify-content-between">
                           <!-- Month Filter -->
                           <div class="d-flex align-items-center mr-4">
                              <label for="month" class="mr-2" style="margin-top:10px;">Select Month:</label>
                              <select name="month" id="month" class="form-control form-select" style="width: 150px;" onchange="this.form.submit()">
                              @foreach(range(1, now()->month) as $month)
                              <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                              {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                              </option>
                              @endforeach
                              </select>
                           </div>
                           <!-- Employee Filter -->
                           <div class="d-flex align-items-center">
                                <?php
                                $employeesReportingTo = \DB::table('hrm_employee')
                                    ->select('EmployeeID', 'fname', 'sname', 'lname')
                                    ->whereIn('EmployeeID', function ($query) {
                                        $query->select('EmployeeID')
                                            ->from('hrm_employee_general')
                                            ->where('RepEmployeeID', Auth::user()->EmployeeID);
                                    })
                                    ->where('hrm_employee.EmpStatus','=','A')
                                    ->get();  // Get all employees reporting to the RepEmployeeID
                                ?>
                                <label for="employee" class="mr-2" style="margin-top:10px;">Select Employee:</label>
                                <select name="employee" id="employee" class="form-control form-select" style="width: 200px;" onchange="this.form.submit()">
                                    <option value="" {{ request('employee') == '' ? 'selected' : '' }}>All</option>
                                    @foreach ($employeesReportingTo as $employee)
                                        <option value="{{ Crypt::encrypt($employee->EmployeeID) }}" {{ request('employee') == Crypt::encrypt($employee->EmployeeID) ? 'selected' : '' }}>
                                            {{ $employee->fname }} {{ $employee->sname }} {{ $employee->lname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </form>
                     </div>
                     <!-- Table Display -->
                     <div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
                        <table id="dailyReportsTable" class="table text-center" style="width:100%; table-layout: auto;">
                           <thead>
                              <tr>
                                 <th class="th" style="width:30px;">Sn</th>
                                 <th class="th" style="width:50px;">EC</th>
                                 <th class="th" style="width:200px;">Name</th>
                                 <th class="th" style="width:100px;">Location</th>
                                 <th class="th" style="width:100px;">Date</th>
                                 <th class="th" style="width:250px;">Reports</th>
                                 <th class="th" style="width:100px;">SignIn Time</th>
                                 <th class="th" style="width:350px;">SignIn Location</th>
                                 <th class="th" style="width:100px;">SignOut Time</th>
                                 <th class="th" style="width:350px;">SignOut Location</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach ($dailyreports as $index => $report)
                              <tr>
                                 <td>{{ $index + 1 }}</td>
                                 <td>{{ $report->EmpCode }}</td>
                                 <td>{{ $report->Fname }} {{ $report->Sname }} {{ $report->Lname }}</td>
                                 <td>{{ $report->city_village_name }}</td>
                                 <td>{{ \Carbon\Carbon::parse($report->MorEveDate)->format('d-m-Y') }}</td>
                                 <td>{{ $report->MorReports ?? 'N/A' }}</td>
                                 <td>{{ \Carbon\Carbon::parse($report->SignIn_Time)->format('H:i:s') ?? 'N/A' }}</td>
                                 <td>{{ $report->SignIn_Loc ?? 'N/A' }}</td>
                                 <td>{{ \Carbon\Carbon::parse($report->SignOut_Time)->format('H:i:s') ?? 'N/A' }}</td>
                                 <td>{{ $report->SignOut_Loc ?? 'N/A' }}</td>
                              </tr>
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
            @include('employee.footerbottom')
         </div>
      </div>
   </div>
   @include('employee.footer');
   <script>
      $(document).ready(function() {
          $('#dailyReportsTable').DataTable({
              "paging": true,            // Enable pagination
              "pagingType": "full_numbers", // Use full pagination buttons (Next, Previous, etc.)
              "lengthMenu": [10, 25, 50, 100], // Set page length options
              "ordering":false,
          });
      });
      $('#dailyReportsTable').css('font-family', 'Roboto, sans-serif');
      $('#dailyReportsTable').find('th, td').css('font-family', 'Roboto, sans-serif');
      
   </script>
   </script>
   <script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>
   <style>
   #dailyReportsTable {
   width: 100%; 
   table-layout: auto; /* Automatically adjust column widths */
   }
   #dailyReportsTable th, #dailyReportsTable td {
   white-space: normal; /* Allow text to wrap */
   word-wrap: break-word; /* Force word wrapping for long words */
   padding: 8px; /* Add padding for readability */
   text-align: left; /* Align text to the left */
   }