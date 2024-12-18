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
                        <a href="{{route('salary')}}" title="Salary">
                            <span class="icon-menu feather-icon text-center">
                                <i class="fas fa-rupee-sign"></i>
                                <br>
                                <span class="menu-text-c">
                                    Salary
                                </span>
                            </span>

                        </a>
                    </li>

                    <li>
                        <a href="{{route('pms')}}" title="PMS">
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
                                ->join('hrm_department', 'hrm_department.DepartmentID', '=', 'hrm_employee_separation_nocdept_emp.DepartmentID')
                                ->where('hrm_employee_separation_nocdept_emp.CompanyID', $companyId)  // Match with the CompanyID from hrm_general
                                ->whereIn('hrm_department.DepartmentCode', ['LOGISTICS', 'IT','FINANCE','HR'])  // Filter departments LOGISTICS and IT
                                ->select('hrm_employee_separation_nocdept_emp.EmployeeID', 'hrm_department.DepartmentCode', 'hrm_department.DepartmentID')  // Select relevant fields
                                ->get();
                        // Get the department of the currently logged-in user
                        $userDepartment = $employeeDepartmentDetails->firstWhere('EmployeeID', $userEmployeeId)->DepartmentCode ?? null;
                        // Fetching approved employees with additional employee details
                        $approvedEmployees = DB::table('hrm_employee_separation as es')
                                        ->join('hrm_employee as e', 'es.EmployeeID', '=', 'e.EmployeeID')  // Join to fetch employee details
                                        ->join('hrm_employee_general as eg', 'e.EmployeeID', '=', 'eg.EmployeeID')  // Join to fetch general employee details
                                        ->join('hrm_department as d', 'eg.DepartmentId', '=', 'd.DepartmentId')  // Join to fetch department name
                                        ->join('hrm_designation as dg', 'eg.DesigId', '=', 'dg.DesigId')  // Join to fetch designation name
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
                                        'd.DepartmentName',  // Department name
                                        'eg.EmailId_Vnr',  // Email ID from the employee general table
                                        'dg.DesigName'  // Designation name
                                    )
                                    ->get();
                    @endphp
                    @if($approvedEmployees->contains('Rep_EmployeeID', Auth::user()->EmployeeID))
                    <li>
                                <a href="{{route('department.clearance')}}" title="Account Clearance">
                                    <span class="icon-menu feather-icon text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-credit-card nav-icon">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg><br>
                                        <span class="menu-text-c">
                                        Department <br>Noc form                    </span>
                                                        </span>
                                                    </a>
                    </li>
                    @endif
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
                                            IT Clearance
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if($userDepartment === 'LOGISTICS')
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
                                            Logistics Clearance
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
                                            HR Clearance
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endif

                        @if($userDepartment === 'FINANCE')
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
                                            Account Clearance
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