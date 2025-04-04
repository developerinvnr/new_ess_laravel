      <!-- ========== App Menu ========== -->
      <div class="app-menu navbar-menu">
          <!-- LOGO Vertical-->
          <div class="navbar-brand-box">
              <!-- Dark Logo-->
              <a href="index.html" class="logo logo-dark">
                  <span class="logo-sm">
                      <img src="{{ URL::to('/') }}/assets/images/mini-logo.png" alt="" height="50">
                  </span>
                  <span class="logo-lg">
                      <img src="{{ URL::to('/') }}/assets/images/login-logo.png" alt="" height="60">
                  </span>
              </a>
              <!-- Light Logo-->
              <a href="index.html" class="logo logo-light">
                  <span class="logo-sm">
                      <img src="{{ URL::to('/') }}/assets/images/mini-logo.png" alt="" height="50">
                  </span>
                  <span class="logo-lg">
                      <img src="{{ URL::to('/') }}/assets/images/login-logo.png" alt="" height="60">
                  </span>
              </a>
              <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                  id="vertical-hover">
                  <i class="ri-record-circle-line"></i>
              </button>
          </div>


          <div id="scrollbar">
              <div class="container-fluid">


                  <div id="two-column-menu">
                  </div>
                  <ul class="navbar-nav" id="navbar-nav">
                      <li class="nav-item">
                          <a class="nav-link menu-link" href="{{ route('manage/dashboard') }}" aria-expanded="false">
                              <i class="las la-home"></i> <span data-key="t-dashboards">Dashboards</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link menu-link" href="{{route('manage/basic')}}" aria-expanded="false">
                              <i class="ri-apps-2-line"></i> <span data-key="t-apps">Basic</span>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="https://hrrec.vnress.in" target="_blank" role="button"
                              aria-expanded="false" aria-controls="sidebarRecruitment">
                              <i class="ri-layout-3-line"></i> <span data-key="t-authentication">Recruitment</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarAuth">
                              <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Assets</span>
                          </a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarPages">
                              <i class="ri-pages-line"></i> <span data-key="t-pages">Leave</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarLanding" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarLanding">
                              <i class="ri-rocket-line"></i> <span data-key="t-landing">Attendance</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarUI" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarUI">
                              <i class="ri-pencil-ruler-2-line"></i> <span data-key="t-base-ui">Payroll</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarAdvanceUI" data-bs-toggle="collapse"
                              role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                              <i class="ri-stack-line"></i> <span data-key="t-advance-ui">Eligibility</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="widgets.html">
                              <i class="ri-honour-line"></i> <span data-key="t-widgets">Hr Operations</span>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarForms" data-bs-toggle="collapse"
                              role="button" aria-expanded="false" aria-controls="sidebarForms">
                              <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Separation</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarTables" data-bs-toggle="collapse"
                              role="button" aria-expanded="false" aria-controls="sidebarTables">
                              <i class="ri-layout-grid-line"></i> <span data-key="t-tables">PMS</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarCharts" data-bs-toggle="collapse"
                              role="button" aria-expanded="false" aria-controls="sidebarCharts">
                              <i class="ri-pie-chart-line"></i> <span data-key="t-charts">Compliance</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarIcons" data-bs-toggle="collapse"
                              role="button" aria-expanded="false" aria-controls="sidebarIcons">
                              <i class="ri-compasses-2-line"></i> <span data-key="t-icons">LMS</span>
                          </a>

                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                              aria-expanded="false" aria-controls="sidebarMaps">
                              <i class="ri-map-pin-line"></i> <span data-key="t-maps">Link & Other</span>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a class="nav-link menu-link" href="{{ route('logout') }}"onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                              <i class="mdi mdi-logout"></i> <span data-key="t-maps">Logout</span>
                          </a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </li>

                  </ul>
              </div>
              <!-- Sidebar -->
          </div>

          <div class="sidebar-background"></div>
      </div>
      <!-- Left Sidebar End -->
