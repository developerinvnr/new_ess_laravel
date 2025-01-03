@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
<div id="loader" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>

                        </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('employee.head')
        <!-- Container Start -->
        <div class="page-wrapper">
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
                                    <li class="breadcrumb-link active">Attendance/Leave</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center;">
    <span><b><h1>PMS under development</h1></b></span>
</div>



    @include('employee.footer')

