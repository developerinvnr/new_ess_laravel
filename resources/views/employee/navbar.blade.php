

@if(\DB::table('notifications_wishes')->where('wishes_to', \Auth::user()->EmployeeID)->count() > 0)

<div class="notification-wrapper header-links">
    <a href="javascript:void(0);" class="notification-info">
        <span class="header-icon">
            <svg enable-background="new 0 0 512 512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="m450.201 407.453c-1.505-.977-12.832-8.912-24.174-32.917-20.829-44.082-25.201-106.18-25.201-150.511 0-.193-.004-.384-.011-.576-.227-58.589-35.31-109.095-85.514-131.756v-34.657c0-31.45-25.544-57.036-56.942-57.036h-4.719c-31.398 0-56.942 25.586-56.942 57.036v34.655c-50.372 22.734-85.525 73.498-85.525 132.334 0 44.331-4.372 106.428-25.201 150.511-11.341 24.004-22.668 31.939-24.174 32.917-6.342 2.935-9.469 9.715-8.01 16.586 1.473 6.939 7.959 11.723 15.042 11.723h109.947c.614 42.141 35.008 76.238 77.223 76.238s76.609-34.097 77.223-76.238h109.947c7.082 0 13.569-4.784 15.042-11.723 1.457-6.871-1.669-13.652-8.011-16.586zm-223.502-350.417c0-14.881 12.086-26.987 26.942-26.987h4.719c14.856 0 26.942 12.106 26.942 26.987v24.917c-9.468-1.957-19.269-2.987-29.306-2.987-10.034 0-19.832 1.029-29.296 2.984v-24.914zm29.301 424.915c-25.673 0-46.614-20.617-47.223-46.188h94.445c-.608 25.57-21.549 46.188-47.222 46.188zm60.4-76.239c-.003 0-213.385 0-213.385 0 2.595-4.044 5.236-8.623 7.861-13.798 20.104-39.643 30.298-96.129 30.298-167.889 0-63.417 51.509-115.01 114.821-115.01s114.821 51.593 114.821 115.06c0 .185.003.369.01.553.057 71.472 10.25 127.755 30.298 167.286 2.625 5.176 5.267 9.754 7.861 13.798z">
                </path>
            </svg>
        </span>
        <span class="count-notification"></span>
    </a>
    <!-- Only show the notification section if the user has notifications -->
    <div class="recent-notification">
        <div class="drop-down-header">
            <h4>All Notification</h4>
            <p>You have {{ \DB::table('notifications_wishes')->where('wishes_to', \Auth::user()->EmployeeID)->count() }} new notifications</p>
        </div>
        <ul>
            @foreach(\DB::table('notifications_wishes')->where('wishes_to', \Auth::user()->EmployeeID)->orderBy('created_at', 'desc')->limit(6)->get() as $notification)
                <li>
                    <a href="javascript:void(0);">
                        <h5><i class="far fa-envelope mr-2"></i>
                            @if($notification->wishes_type == 'birthday')
                                Birthday Wish from {{$notification->from_wishes_name}} - <p>{{ $notification->wishes_message }}</p>
                            @elseif($notification->wishes_type == 'joining')
                                Corporate Anniversary {{$notification->from_wishes_name}} - <p>{{ $notification->wishes_message }}</p>
                            @elseif($notification->wishes_type == 'marriage')
                                Marriage Anniversary {{$notification->from_wishes_name}} - <p>{{ $notification->wishes_message }}</p>
                            @endif
                        </h5>
                        
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
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
                <a title="Change Password" href="{{ route(name: 'change-password') }}">
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