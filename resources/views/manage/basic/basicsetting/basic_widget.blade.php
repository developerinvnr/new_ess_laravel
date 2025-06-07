<div class="row">
    <div class="col-12">    
        <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
           <a href="{{ route('manage/basic_master') }}">
                <div class="card-body d-flex align-items-center p-0">
                    
                <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <!-- SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-users icon-dual-success">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-grow-1 top-h-menu">
                        <p class="mb-0">Master</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
            <a href="{{ route('manage/workflow_master') }}">
                <div class="card-body d-flex align-items-center p-0 {{request()->routeIs('manage/workflow_master') ? 'bg-success-subtle' : ''}}">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <i style="color: #39b29c;font-size:14px;" class="ri-git-merge-line"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 top-h-menu">
                        <p class="mb-0">Workflow</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
            <a href="report.html">
                <div class="card-body d-flex align-items-center p-0">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <!-- SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-users icon-dual-success">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-grow-1 top-h-menu">
                        <p class="mb-0">Reports</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
            <a href="trigger.html">
                <div class="card-body d-flex align-items-center p-0">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <!-- SVG icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-users icon-dual-success">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-grow-1 top-h-menu">
                        <p class="mb-0">Trigger</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
            <a href="notification.html">
                <div class="card-body d-flex align-items-center p-0">
                    <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <i style="color: #39b29c;font-size:14px;" class="ri-notification-badge-line"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 top-h-menu">
                        <p class="mb-0">Notification</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px; min-width: 105px;text-align: center;float: left;background-color: #a9cbcd;">
                <a href="{{ route('manage/basicsetting_master') }}">
                    <div class="card-body d-flex align-items-center p-0 {{ request()->is('manage/basicsetting_master') ? 'bg-success-subtle' : '' }}">
                        <div class="avatar-sm">
                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                            <i style="color: #39b29c;font-size:14px;" class="ri-settings-2-line"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 top-h-menu">
                        <p class="mb-0">Setting</p>
                    </div>
                </div>
            </a>
        </div>

         <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
                                <a href="policy.html">
                                <div class="card-body d-flex align-items-center p-0">
                                    <div class="avatar-sm">
                                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                                            <i style="color: #39b29c;font-size:14px;" class=" ri-settings-2-line"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 top-h-menu">
                                        <p class="mb-0">Policy</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                        
                            <div class="card mb-1" style="width:auto;padding: 3px;margin-left:10px;min-width: 105px;text-align: center;float: left;">
                                <a href="transaction-dashboard.html">
                                <div class="card-body d-flex align-items-center p-0">
                                    <div class="avatar-sm">
                                        <div class="avatar-title border bg-success-subtle border-success border-opacity-25 rounded-2 fs-17">
                                            <i style="color: #39b29c;font-size:14px;" class="las la-exchange-alt"></i>
                                            
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 top-h-menu">
                                        <p class="mb-0">Transactions</p>
                                    </div>
                                </div>
                                </a>
                            </div>
                </div> <!-- .col-12 -->
            </div> <!-- .row -->
