@php
    $notification = \App\Models\Backend\Notification::where('userid', Auth::user()->EmployeeID)
        ->where('notification_read', 0)
        ->orderBy('id', 'DESC')
        ->get();
    $notificationCount = $notification->count();

@endphp
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO for horizontal-->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::to('/') }}/assets/images/mini-logo.png" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::to('/') }}/assets/images/login-logo.png" alt="" height="60">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::to('/') }}/assets/images/mini-logo.png" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ URL::to('/') }}/assets/images/login-logo.png" alt="" height="60">
                        </span>
                    </a>
                </div>





            </div>

            <div class="d-flex align-items-center">





                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button"
                        class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
                        id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                        aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if ($notificationCount > 0)
                            <span
                                class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">{{ $notificationCount }}<span
                                    class="visually-hidden">unread messages</span></span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                    </div>
                                    @if ($notificationCount > 0)
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge bg-light text-body fs-13"> {{ $notificationCount }}
                                                New</span>
                                        </div>
                                    @endif
                                </div>
                            </div>


                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    @foreach ($notification as $item)
                                        <div
                                            class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="flex-grow-1">
                                                    <a href="javascript:void(0);" class="stretched-link"
                                                        onclick="readNotification({{ $item->id }})">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">{{ $item->title }}</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">{{ $item->description }}</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted"
                                                        style="float:right;">
                                                        <span><i class="mdi mdi-clock-outline"></i>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="my-3 text-center view-all">
                                        <button type="button" class="btn btn-soft-success waves-effect waves-light">
                                            View
                                            All Notifications <i class="ri-arrow-right-line align-middle"></i>
                                        </button>
                                    </div>
                                </div>

                            </div>


                            <div class="notification-actions" id="notification-actions">
                                <div class="d-flex text-muted justify-content-center">
                                    Select
                                    <div id="select-content" class="text-body fw-semibold px-1">0</div>
                                    Result
                                    <button type="button" class="btn btn-link link-danger p-0 ms-3"
                                        data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ getEmployeeImage(Auth::user()->EmployeeID) }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ getFullName(Auth::user()->EmployeeID) }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Administrator</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{route('dashboard')}}"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Employee Panel</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout"> {{ __('Logout') }}</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
