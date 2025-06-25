@include('employee.header')


<body class="mini-sidebar">

    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->


        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                               
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard start -->


           <div class="py-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">

                            @if (session('message'))
                                <h5 class="alert alert-success mb-2">{{ session('message') }}</h5>
                            @endif

                            @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                            @endif

                            <div class="card shadow">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0 text-white">Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('change-password') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label>Current Password</label>
                                            <input type="password" name="current_password" class="form-control" />
                                        </div>
                                        <div class="mb-3">
                                            <label>New Password</label>
                                            <input type="password" name="password" class="form-control" />
                                        </div>
                                        <div class="mb-3">
                                            <label>Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control" />
                                        </div>
                                        <div class="mb-3 text-end">
                                            <hr>
                                            <button type="submit" class="btn btn-primary">Update Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`


            </div>
        </div>

        
        @include('employee.footer');
