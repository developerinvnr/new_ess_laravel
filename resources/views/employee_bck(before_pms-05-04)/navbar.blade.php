
@php
    $userId = Auth::user()->EmployeeID;
    $wishesCount = \DB::table('notifications_wishes')->where('wishes_to', $userId)->count();
    $notificationsCount = \DB::table('notification')->where('userid', $userId)->where('notification_read', 0)->count();

    $wishes = \DB::table('notifications_wishes')
        ->where('wishes_to', $userId)
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

    $notifications = \DB::table('notification')
        ->where('userid', $userId)
        ->where('notification_read', 0)
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();
@endphp

@if($wishesCount > 0 || $notificationsCount > 0)
<div class="notification-wrapper header-links">

    <!-- Wishes Notification Bell -->
    @if($wishesCount > 0)
        <a href="javascript:void(0);" class="notification-info">
            <span class="header-icon">
                <!-- Bell Icon -->
                <i class="fas fa-birthday-cake"></i>
            </span>
            <span class="count-notification">{{ $wishesCount }}</span>
        </a>
        <div class="recent-notification">
            <div class="drop-down-header">
                <h4>Wishes</h4>
                <p>You have {{ $wishesCount }} new wishes</p>
            </div>
            <ul>
                @foreach($wishes as $wish)
                    <li>
                        <a href="javascript:void(0);">
                            <h5>
                                <i class="far fa-envelope mr-2"></i>
                                @if($wish->wishes_type == 'birthday')
                                    Birthday Wish from {{$wish->from_wishes_name}} - <p>{{ $wish->wishes_message }}</p>
                                @elseif($wish->wishes_type == 'joining')
                                    Corporate Anniversary {{$wish->from_wishes_name}} - <p>{{ $wish->wishes_message }}</p>
                                @elseif($wish->wishes_type == 'marriage')
                                    Marriage Anniversary {{$wish->from_wishes_name}} - <p>{{ $wish->wishes_message }}</p>
                                @endif
                            </h5>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- General Notification Bell -->
    @if($notificationsCount > 0)
        <a href="javascript:void(0);" class="notification-info">
            <span class="header-icon">
                <!-- Bell Icon -->
                <i class="fas fa-bell"></i>
            </span>
            <span class="count-notification">{{ $notificationsCount }}</span>
        </a>
        <div class="recent-notification">
            <div class="drop-down-header">
                <h4>Notifications</h4>
                <p>You have {{ $notificationsCount }} new notifications</p>
            </div>
            <ul>
                @foreach($notifications as $notification)
                    <li>
                        <a href="{{ route('notification.read', ['id' => $notification->id]) }}">
                            <h5>
                                <i class="far fa-envelope mr-2"></i>
                                <p>{{ $notification->description }}</p>
                            </h5>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

</div>
@endif

<div class="user-info-wrapper header-links">
    <!-- <a href="javascript:void(0);" class="user-info">

        <img src="https://eu.ui-avatars.com/api/?name={{ Auth::user()->Fname }}&background=A585A3&color=fff&bold=true&length=1&font-size=0.5"
            alt="user-img" style="height: 40px;
    width: 40px;
    object-fit: cover;
    border: none;
    border-radius: 50%;">

    </a> -->
    @php
    $imagpath = Auth::user()->CompanyId;
    @endphp

    <a href="javascript:void(0);" class="user-info">
    <img src="https://vnrseeds.co.in/AdminUser/EmpImg{{$imagpath}}Emp/{{ Auth::user()->EmpCode }}.jpg" 
    alt="user-img" style="height: 40px; width: 40px; object-fit: cover; border: none; border-radius: 50%;">

</a>
    <div class="user-info-box">
        <div class="drop-down-header">
            <h4>{{ Auth::user()->Fname . ' ' . Auth::user()->Sname . ' ' . Auth::user()->Lname }}</h4>
            <p>{{ ucwords(strtolower(Auth::user()->designation->designation_name ?? 'No Designation')) }}</p>
            <p>Emp. Code - {{ Auth::user()->EmpCode}}</p>
        </div>
        <ul>
            <li>
                <a title="Profile" href="{{ route('profile') }}">
                    <i class="far fa-user"></i> Profile
                </a>
            </li>
            <!-- <li>
                <a title="Admin" href="admin.html">
                    <i class="fas fa-cog"></i> Admin
                </a>
            </li> -->
            <li>
                <a title="Change Passward" href="{{ route(name: 'change-password') }}">
                    <i class="fas fa-cog"></i> Change Password
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form-1" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>