 
 <!-- Sidebar Start -->
 <aside class="sidebar-wrapper">
            <div class="logo-wrapper">
                <a href="{{route('dashboard')}}" class="admin-logo">
                    <img src="./images/mini-logo.png" alt="" class="sp_logo">
                    <img src="./images/mini-logo.png" alt="" class="sp_mini_logo">
                </a>
            </div>
            <div class="side-menu-wrap active">
                <ul class="main-menu in">
                    <li>
                        <a href="{{route('dashboard')}}" class="active" title="Home">
                            <span class="icon-menu feather-icon text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg><br>
                                <span class="menu-text-c">Home</span>
                            </span>

                        </a>
                    </li>
                    @php
                    // Check if the employee exists and is active
                    $exists = DB::table('hrm_employee')
                        ->leftjoin('hrm_employee_general', 'hrm_employee.EmployeeID', '=', 'hrm_employee_general.RepEmployeeID')
                        ->where('hrm_employee.EmployeeID', Auth::user()->EmployeeID)
                        ->where('hrm_employee.EmpStatus', 'A')
                        ->whereNotNull('hrm_employee_general.RepEmployeeID')
                        ->exists();
                    @endphp
                    @if ($exists)
                        <li>
                            <a href="{{ route('team') }}" title="My Team">
                                <span class="icon-menu feather-icon text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg><br>
                                    <span class="menu-text-c">My Team</span>
                                </span>
                            </a>
                        </li>
                        @elseif(Auth::user()->MoveRep == 'Y')
                            @php
                                // Initialize $eet to an empty string or null to avoid the undefined variable error
                                $eet = '';

                                // Fetch the report data
                                $rpt = DB::select("SELECT r.EmployeeID from hrm_employee_reporting r 
                                                LEFT JOIN hrm_employee e ON r.EmployeeID = e.EmployeeID 
                                                WHERE e.EmpStatus = 'A' AND e.CompanyId = ? 
                                                AND (r.AppraiserId = ? OR r.ReviewerId = ? OR r.HodId = ?)", 
                                                [Auth::user()->CompanyId, Auth::user()->EmployeeID, Auth::user()->EmployeeID, Auth::user()->EmployeeID]);
                                
                                $array_et = array();
                                
                                if(count($rpt) > 0) {
                                    foreach($rpt as $rpvt) {
                                        $array_et[] = $rpvt->EmployeeID;
                                    }
                                    $eet = implode(',', $array_et); // Create the comma-separated string
                                }

                                // Fetch the employee data for MoveRep
                                $svs = DB::select("SELECT * FROM hrm_employee WHERE EmployeeID = ?", [Auth::user()->EmployeeID]);
                                $resv = $svs[0];

                                // Determine Employee ID to use
                                if ($resv->MoveRep == 'Y') {
                                    if ($resv->Ref_ID != '' && $resv->Ref_ID != NULL) {
                                        $EId = $resv->Ref_ID;
                                    } else {
                                        $EId = $resv->EmployeeID;
                                    }
                                }
                            @endphp

                            @if ($resv->MoveRep == 'Y')
                                <li>
                                    <a href="https://www.vnress.in/Employee/RepIndxHome.php?ID={{ $EId }}&eet={{ $eet }}" target="_blank" style="color:blue"><span class="icon-menu feather-icon text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg><br>
                                    <span class="menu-text-c">Other Team</span>
                                </span></a>
                                </li>
                            @endif
                        @endif


                    <li>
                        <a href="{{ route('attendanceView', ['employeeId' => Auth::user()->EmployeeID]) }}" title="Attendance">
                            <span class="icon-menu feather-icon text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-calendar">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg><br>
                                <span class="menu-text-c">
                                    Attendance
                                </span>
                            </span>

                        </a>
                    </li>
                    <li>
                        <a href="{{route('verify.password')}}" title="Salary">
                            <span class="icon-menu feather-icon text-center">
                                <i class="fas fa-rupee-sign"></i>
                                <br>
                                <span class="menu-text-c">
                                    Salary
                                </span>
                            </span>

                        </a>
                    </li>

                    <!--<li>-->
                    <!--    <a href="{{route('pmsinfo')}}" title="PMS">-->
                    <!--        <span class="icon-menu feather-icon text-center">-->
                    <!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"-->
                    <!--                stroke="currentColor" stroke-width="2" stroke-linecap="round"-->
                    <!--                stroke-linejoin="round" class="feather feather-grid nav-icon">-->
                    <!--                <rect x="3" y="3" width="7" height="7"></rect>-->
                    <!--                <rect x="14" y="3" width="7" height="7"></rect>-->
                    <!--                <rect x="14" y="14" width="7" height="7"></rect>-->
                    <!--                <rect x="3" y="14" width="7" height="7"></rect>-->
                    <!--            </svg><br>-->
                    <!--            <span class="menu-text-c">-->
                    <!--                PMS-->
                    <!--            </span>-->
                    <!--        </span>-->

                    <!--    </a>-->
                    <!--</li>-->
                    @php
                    // Get the current month and year
                    $userEmployeeId = Auth::user()->EmployeeID;

                    $companyId = DB::table('hrm_employee')
                        ->where('EmployeeID', $userEmployeeId)
                        ->pluck('CompanyId')
                        ->first();  // Using first() to get a single value (CompanyID)

                        // Fetch EmployeeIDs and their respective DepartmentCodes for departments LOGISTICS and IT
                        $employeeDepartmentDetails = DB::table('hrm_employee_general')
                            ->join('core_departments', 'core_departments.id', '=', 'hrm_employee_general.DepartmentId')
                            ->whereIn('core_departments.department_code', ['IT','HR'])
                            ->select('hrm_employee_general.EmployeeID', 'core_departments.department_code', 'core_departments.id')  // Select relevant fields
                            ->get();
                    // Get the department of the currently logged-in user
                    $userDepartment = $employeeDepartmentDetails->firstWhere('EmployeeID', $userEmployeeId)->department_code ?? null;
                    @endphp
                    <li>
                        <a href="{{route('pmsinfo')}}" title="PMS">
                            <span class="icon-menu feather-icon text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-grid nav-icon">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg><br>
                                <span class="menu-text-c">
                                    PMS
                                </span>
                            </span>

                        </a>
                    </li>

                   

                    <li>
                        <a href="{{route('assests')}}" title="Assets">
                            <span class="icon-menu feather-icon text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg><br>
                                <span class="menu-text-c">
                                    Assets
                                </span>
                            </span>

                        </a>
                    </li>

                    <li>
                        <a href="{{route('query')}}" title="Query">
                            <span class="icon-menu feather-icon text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-layers">
                                    <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                                    <polyline points="2 17 12 22 22 17"></polyline>
                                    <polyline points="2 12 12 17 22 12"></polyline>
                                </svg><br>
                                <span class="menu-text-c">
                                    Query
                                </span>
                            </span>

                        </a>
                    </li>
                    @php
                        $userEmployeeId = Auth::user()->EmployeeID;
                            // Get the current month and year
                            $currentMonth = \Carbon\Carbon::now()->month;
                            $currentYear = \Carbon\Carbon::now()->year;
                        $companyId = DB::table('hrm_employee')
                            ->where('EmployeeID', $userEmployeeId)
                            ->pluck('CompanyId')
                            ->first();  // Using first() to get a single value (CompanyID)

                            // Fetch EmployeeIDs and their respective DepartmentCodes for departments LOGISTICS and IT
                            $employeeDepartmentDetails = DB::table('hrm_employee_separation_nocdept_emp')
                                ->join('core_departments', 'core_departments.id', '=', 'hrm_employee_separation_nocdept_emp.DepartmentID')
                                ->where('hrm_employee_separation_nocdept_emp.CompanyID', $companyId)  // Match with the CompanyID from hrm_general
                                ->whereIn('core_departments.department_code', ['MIS', 'IT','FIN','HR'])  // Filter departments LOGISTICS and IT
                                ->select('hrm_employee_separation_nocdept_emp.EmployeeID', 'core_departments.department_code', 'core_departments.id')  // Select relevant fields
                                ->get();
                        // Get the department of the currently logged-in user
                        $userDepartment = $employeeDepartmentDetails->firstWhere('EmployeeID', $userEmployeeId)->department_code ?? null;
                        // Fetching approved employees with additional employee details
                        $approvedEmployees = DB::table('hrm_employee_separation as es')
                                        ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                                        ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                                        ->join('core_departments as d', 'eg.DepartmentId', '=', 'd.id')  // Join to fetch department name
                                        ->join('core_designation as dg', 'eg.DesigId', '=', 'dg.id')  // Join to fetch designation name
                                        ->where('es.Rep_Approved', 'Y')  // Only those with Rep_Approved = 'Y'
                                        ->where('es.HR_Approved', 'Y')  // Only those with HR_Approved = 'Y'
                                        ->where(function($query) {
                                            // Add condition to check if Rep_EmployeeID or HR_UserId matches the authenticated user's EmployeeID
                                            $query->where('es.Rep_EmployeeID', Auth::user()->EmployeeID)
                                                ->orWhere('es.HR_UserId', Auth::user()->EmployeeID);
                                        })
                                    ->whereMonth('es.created_at', $currentMonth)  // Filter for the current month
                                    ->whereYear('es.created_at', $currentYear)   // Filter for the current year
                                    ->select(
                                        'es.*',
                                        'e.Fname',  // First name
                                        'e.Lname',  // Last name
                                        'e.Sname',  // Surname
                                        'e.EmpCode',  // Employee Code
                                        'd.department_name',  // Department name
                                        'eg.EmailId_Vnr',  // Email ID from the employee general table
                                        'dg.designation_name'  // Designation name
                                    )
                                    ->get();
                    @endphp
                    
                        @if($userDepartment === 'IT')
                            <li>
                                <a href="{{ route('it.clearance') }}" title="IT Clearance">
                                    <span class="icon-menu feather-icon text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-laptop nav-icon">
                                            <rect x="3" y="4" width="18" height="12" rx="2" ry="2"></rect>
                                            <line x1="12" y1="20" x2="12" y2="18"></line>
                                            <line x1="6" y1="22" x2="18" y2="22"></line>
                                        </svg><br>
                                        <span class="menu-text-c">
                                            IT <br>Clearance
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if($userDepartment === 'MIS')
                            <li>
                                <a href="{{ route('logistics.clearance') }}" title="Logistics Clearance">
                                    <span class="icon-menu feather-icon text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-truck nav-icon">
                                            <path d="M3 11V3a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8"></path>
                                            <path d="M16 21a2 2 0 0 1-2 2h-8a2 2 0 0 1-2-2"></path>
                                            <path d="M5 11l2-2h10l2 2"></path>
                                        </svg><br>
                                        <span class="menu-text-c">
                                            Logistics <br>Clearance
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if($userDepartment === 'HR')
                            <li>
                                <a href="{{ route('hr.clearance') }}" title="HR Clearance">
                                    <span class="icon-menu feather-icon text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-users nav-icon">
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        </svg><br>
                                        <span class="menu-text-c">
                                            HR <br>Clearance
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if($userDepartment === 'FIN')
                            <li>
                                <a href="{{ route('account.clearance') }}" title="Account Clearance">
                                    <span class="icon-menu feather-icon text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-credit-card nav-icon">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg><br>
                                        <span class="menu-text-c">
                                            Account<br> Clearance
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endif

                    <!-- <li>
                        <a href="{{route('govtssschemes')}}">
                            <span class="icon-menu feather-icon text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-paperclip">
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48">
                                    </path>
                                </svg><br>
                                <span class="menu-text-c">
                                    Govt. schemes
                                </span>
                            </span>

                        </a>
                    </li> -->
                    <!-- <li>
                        <a href="{{route('exitinterviewform')}}">
                            <span class="icon-menu feather-icon text-center">
                                <i class="fas fa-file-invoice"></i><br>
                                <span class="menu-text-c">
                                    Exit Form
                                </span>
                            </span>

                        </a>
                    </li> -->
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                            <span class="icon-menu feather-icon text-center">
                                <i style="font-size:15px;" class="fas fa-sign-out-alt"></i><br>
                                <span class="menu-text-c">Logout</span>
                            </span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                    <!-- <li>
                        <a href="changes.html">
                            <span class="icon-menu feather-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-paperclip">
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48">
                                    </path>
                                </svg><br>
                                <span class="menu-text-c">
                                    Changes
                                </span>
                            </span>

                        </a>
                    </li> -->
                    <!-- <li>
                        <a target="_blank"
                            href="https://www.figma.com/design/6Jqx89M1WnpneekSoqgULk/Ess-Redesign?node-id=8-704&node-type=canvas&t=1bFUyRNdbJbD0eip-0">
                            <span class="icon-menu feather-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-paperclip">
                                    <path
                                        d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48">
                                    </path>
                                </svg><br>
                                <span class="menu-text-c">
                                    Figma
                                </span>
                            </span>

                        </a>
                    </li>
                    -->
                </ul>

            </div>
        </aside>