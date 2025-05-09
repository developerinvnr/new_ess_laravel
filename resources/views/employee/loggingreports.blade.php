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
                <form method="GET" action="{{ url()->current() }}" class="d-flex justify-content-between" id="filterForm">
    <div class="input-group">
        <!-- Start Date -->
        <input type="date" name="start_date" class="form-control" value="{{ request('start_date', \Carbon\Carbon::now()->startOfMonth()->toDateString()) }}" onchange="this.form.submit()">
        <!-- End Date -->
        <input type="date" name="end_date" class="form-control" value="{{ request('end_date', \Carbon\Carbon::now()->endOfMonth()->toDateString()) }}" onchange="this.form.submit()">
    </div>

    <div class="input-group">
        <!-- Status Dropdown -->
        <select name="status" class="form-control" onchange="this.form.submit()">
            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
            <option value="A" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="D" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <?php
        $employeesReportingTo = \DB::table('hrm_employee')
            ->select('EmployeeID', 'fname', 'sname', 'lname')
            ->whereIn('EmployeeID', function ($query) {
                $query->select('EmployeeID')
                    ->from('hrm_employee_general')
                    ->where('RepEmployeeID', Auth::user()->EmployeeID);
            })
            ->where('hrm_employee.EmpStatus','=','A')
            ->get();  
    ?>

    <div class="input-group">
        <!-- Employee Dropdown -->
        <select name="employee_id" class="form-control" onchange="this.form.submit()">
            <option value="">Select Employee</option>

            @foreach($employeesReportingTo as $employee)
                <option value="{{ Crypt::encrypt($employee->EmployeeID) }}" {{ request('employee_id') == Crypt::encrypt($employee->EmployeeID) ? 'selected' : '' }}>
                    {{ $employee->fname }} {{ $employee->sname }} {{ $employee->lname }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<div class="container">
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
       // Google Map Integration
       function initMap() {
        const map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: 0, lng: 0 },
            zoom: 12
        });

        // Loop through your location tracking data and plot the points on the map
        @foreach ($allLocationTracking as $employeeID => $locationTrackings)
            @foreach ($locationTrackings as $location)
                // Only plot if latitude and longitude are available
                if ({!! $location->DLat !!} && {!! $location->DLong !!}) {
                    new google.maps.Marker({
                        position: { lat: {!! $location->DLat !!}, lng: {!! $location->DLong !!} },
                        map: map,
                        title: '{{ $location->Fname }} {{ $location->Sname }} {{ $location->Lname }}'
                    });
                }

            @endforeach
        @endforeach
    }
    
    function loadScript() {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyCX-IBGudyr19-E7zrx1PTGqy0PEVwX5wQ&callback=initMap&v=beta`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}
loadScript();

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