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
                        <a href="{{route('seperation')}}" class="active" title="Home">
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
                        // Get the authenticated user's EmployeeID
                        $employeeId = Auth::user()->EmployeeID;

                        // Check if the EmployeeID exists in hrm_employee_separation with both Rep_Approved and HR_Approved = 'Y'
                        $exitFormAvailable = \App\Models\EmployeeSeparation::where('EmployeeID', $employeeId)
                                            ->where('Rep_Approved', 'Y')
                                            ->where('HR_Approved', 'Y')
                                            ->exists();
                    @endphp

                    <!-- Conditionally display the menu item if the condition is met -->
                    @if($exitFormAvailable)
                        <li>
                            <a href="{{ route('exitinterviewform') }}">
                                <span class="icon-menu feather-icon text-center">
                                    <i class="fas fa-file-invoice"></i><br>
                                    <span class="menu-text-c">
                                        Exit Form
                                    </span>
                                </span>
                            </a>
                        </li>
                    @endif

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