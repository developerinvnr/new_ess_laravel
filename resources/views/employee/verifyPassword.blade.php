@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
<div id="loader" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('employee.head')
        <!-- Sidebar Start -->
        @include('employee.sidebar')
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Salary</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                @include('employee.salaryheader')
                <div class="row">
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                   <!-- Modal body -->
        <form>
        <div class="modal-body">
            <div class="form-group" id="userpassword" style="display: block;">
                <label class="col-form-label">Password</label>
                <input type="text" name="userpassword" class="form-control" id="userpasswordrequest" placeholder="Enter your password">
            </div>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
          <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-bs-dismiss="modal">Close</button>
        </div>
        </form>on type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
                    </div>

                </div>
                

                
                @include('employee.footerbottom')
            </div>
        </div>
    </div>

    

    @include('employee.footer')
