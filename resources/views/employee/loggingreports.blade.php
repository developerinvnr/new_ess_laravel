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
    
    <!-- Main Content Start -->
    <div class="main-content">
        <!-- Page Title Start -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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

        <!-- Location Tracking Section -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card ad-info-card-">
                    <div class="card-header">
                        <h5 class="float-start mt-1"><b>Team Location Tracking</b></h5>
                     
                    </div>
                </div>

                <div class="card-body" style="overflow-y: scroll; overflow-x: hidden;">
                <form method="GET" action="{{ url()->current() }}" class="row g-2 align-items-center" id="filterForm">
    <!-- Start Date -->
    <div class="col-auto">
        <input type="date" name="start_date" class="form-control form-control-sm" style="margin-left: 15px;"
               value="{{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->toDateString()) }}" 
               onchange="this.form.submit()">
    </div>

    <!-- End Date -->
    <div class="col-auto">
        <input type="date" name="end_date" class="form-control form-control-sm" 
               value="{{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->toDateString()) }}" 
               onchange="this.form.submit()">
    </div>

    <!-- Status Dropdown -->
    <div class="col-auto">
        <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
            <option value="A" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="D" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    @php
    // Decrypt the employee_id from the request if available
    $selectedEmployeeId = request('employee_id') ? Crypt::decrypt(request('employee_id')) : null;
@endphp

<?php
    // Fetch employees reporting to the logged-in user
    $employeesReportingTo = DB::table('hrm_employee')
        ->select('EmployeeID', 'fname', 'sname', 'lname')
        ->whereIn('EmployeeID', function ($query) {
            $query->select('EmployeeID')
                ->from('hrm_employee_general')
                ->where('RepEmployeeID', Auth::user()->EmployeeID);
        })
        ->where('hrm_employee.EmpStatus', '=', 'A')
        ->get();  
?>

<!-- Employee Dropdown -->
<div class="col-auto">
    <select name="employee_id" class="form-control form-control-sm" onchange="this.form.submit()">
        <option value="">Select Employee</option>
        @foreach($employeesReportingTo as $employee)
            <option value="{{ Crypt::encrypt($employee->EmployeeID) }}" 
                {{ ($selectedEmployeeId == $employee->EmployeeID) ? 'selected' : '' }}>
                {{ $employee->fname }} {{ $employee->sname }} {{ $employee->lname }}
            </option>
        @endforeach
    </select>
</div>

</form>


<div class="container" style="max-width:1220px;">
    <div class="row">
        <!-- Table displaying location tracking data (on the left) -->
        <div class="col-md-6">
            <table class="table table-bordered mt-3" id="locationtrackingtable">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Latitude</th>
                        <th>Running Km</th>
                        <th>Date Time</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allLocationTracking as $employeeID => $locationTrackings)
                        @foreach ($locationTrackings as $location)
                            <tr>
                                <td>{{ $location->Fname }} {{ $location->Sname }} {{ $location->Lname }}</td>
                                <td>{{ $location->DLat }}</td>
                                <td>{{ isset($location->distance) ? $location->distance : 0 }} Km</td>
                                <td>{{ \Carbon\Carbon::parse($location->DTime)->format('d-m-Y') }}</td>
                                <td>{{ $location->address }}</td>
                            </tr>
                        @endforeach
                        <!-- Total distance row -->
                        @if (isset($totalDistances[$employeeID]))
                            <tr>
                                <td colspan="3"><strong>Total Running Km</strong></td>
                                <td>{{ $totalDistances[$employeeID] }} Km</td>
                                <td></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Map Container (on the right) -->
        <div class="col-md-6">
            <div id="map" style="height: 450px;"></div>
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div> <!-- End of main-content -->


    <!-- Footer -->
    <!-- @include('employee.footerbottom') -->

</div> <!-- End of page-wrapper -->

@include('employee.footer')
<script>
    // Make initMap globally available so that Google can call it.
    window.initMap = function() {
        // Initialize the map.
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 0, lng: 0 },
            zoom: 12
        });

        // Loop through your location tracking data and plot markers/polylines.
        @foreach ($allLocationTracking as $employeeID => $locationTrackings)
            let coordinates_{{ $employeeID }} = [];
            @foreach ($locationTrackings as $location)
                @if($location->DLat && $location->DLong)
                    const position = { lat: {!! $location->DLat !!}, lng: {!! $location->DLong !!} };
                    new google.maps.Marker({
                        position: position,
                        map: map,
                        title: '{{ $location->Fname }} {{ $location->Sname }} {{ $location->Lname }}'
                    });
                    coordinates_{{ $employeeID }}.push(position);
                @endif
            @endforeach
            if (coordinates_{{ $employeeID }}.length > 0) {
                new google.maps.Polyline({
                    path: coordinates_{{ $employeeID }},
                    geodesic: true,
                    strokeColor: "#FF0000",
                    strokeOpacity: 1.0,
                    strokeWeight: 2,
                    map: map
                });
            }
        @endforeach
    };

    // Function to load the Google Maps API asynchronously.
    function loadGoogleMaps() {
        // Only load if not already present.
        if (!window.google || !window.google.maps) {
            const script = document.createElement('script');
            // Note: Replace YOUR_API_KEY with your actual API key.
            script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCX-IBGudyr19-E7zrx1PTGqy0PEVwX5wQ&callback=initMap&libraries=geometry";
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        }
    }

    // Load the API once the window has fully loaded.
    window.addEventListener("load", loadGoogleMaps);
</script>


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