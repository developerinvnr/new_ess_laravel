@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
	<div class="loader" style="display: none;">
	  <div class="spinner" style="display: none;">
		<img src="./SplashDash_files/loader.gif" alt="">
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
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">My Team - Sepration/Clearance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 @include('employee.menuteam')

                <!-- Revanue Status Start -->
                <div class="row">
                  
					
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>Team: Employee Separation Data</b></h5>
                        <div class="flex-shrink-0" style="float:right;">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="base-class" class="form-label text-muted mt-1">HOD/Reviewer</label>
                                <input class="form-check-input code-switcher" type="checkbox" id="base-class">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- Table for displaying separation data -->
                        <table class="table table-bordered">
                            <thead style="background-color:#cfdce1;">
                                <tr>
                                    <th>SN</th>
                                    <th>EC</th>
                                    <th>Employee Name</th>
                                    <th>Function</th>
                                    <th>Resignation Date</th>
                                    <th>Releiving Date</th>
                                    <th>Resignation Reason</th>
                                    <th>Employee Details</th>
                                    <th>Separation Detals</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                                $index = 1;
                            @endphp
                            @forelse($seperationData as $separation)
                                @foreach($separation['seperation'] as $data)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td></td>
                                    <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
                                    <td></td>
                                    <td>
                                        {{ 
                                            $data->Emp_ResignationDate
                                            ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y')
                                            : 'Not specified' 
                                        }}
                                    </td> 
                                    <td>
                                        {{ 
                                            $data->Emp_RelievingDate
                                            ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y')
                                            : 'Not specified' 
                                        }}
                                    </td> 
                                    <td>{{ $data->Emp_Reason ?? 'Not specified' }}</td> <!-- Separation Reason -->
                                    <td><a data-bs-toggle="modal" data-bs-target="#empdetails"
                                        href="">Click</a></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No separation data available for any employee.</td>
                                </tr>
                            @endforelse
                        </tbody>

                        </table>
                    </div>
                </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><b>IT Clearance</b></h5>
    
                        </div>
                        <div class="card-body table-responsive">
                            <!-- Table for displaying separation data -->
                            <table class="table table-bordered">
                                                <thead style="background-color:#cfdce1;">
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>ES</th>
                                                        <th>Employee Name</th>
                                                        <th>Department</th>
                                                        <th>Email</th>
                                                        <th>Resignation Date</th>
                                                        <th>Relieving Date</th>
                                                        <th>Resignation Status</th>
                                                        <th>Clearance Status</th>
                                                        <th>History</th>
                                                        <th>Clearance form</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                    <td>1. Log</td>
                                                   <td>780</td>
                                                   <td>rajendra pal</td>
                                                   <td>FS</td>
                                                   <td>rajendrapal.vspl@gmail.com</td>
                                                   <td>11-08-2024</td>
                                                   <td>11-10-2024</td>
                                                   <td>Yes</td>
                                                   <td>Pending</td>
                                                   <td><a data-bs-toggle="modal" data-bs-target="#empdetails"
                                                    href="">click</td>
                                                   <td><a data-bs-toggle="modal" data-bs-target="#clearnsdetailsLOGISTIC"
                                                    href="">form click</a></td>
                                                   </tr>
                                                   <tr>
                                                    <td>2. IT</td>
                                                   <td>780</td>
                                                   <td>rajendra pal</td>
                                                   <td>FS</td>
                                                   <td>rajendrapal.vspl@gmail.com</td>
                                                   <td>11-08-2024</td>
                                                   <td>11-10-2024</td>
                                                   <td>Yes</td>
                                                   <td>Pending</td>
                                                   <td><a data-bs-toggle="modal" data-bs-target="#empdetails"
                                                    href="">click</td>
                                                   <td><a data-bs-toggle="modal" data-bs-target="#clearnsdetailsIT"
                                                    href="">form click</a></td>
                                                   </tr>
                                                   <tr>
                                                    <td>3. Acco</td>
                                                   <td>780</td>
                                                   <td>rajendra pal</td>
                                                   <td>FS</td>
                                                   <td>rajendrapal.vspl@gmail.com</td>
                                                   <td>11-08-2024</td>
                                                   <td>11-10-2024</td>
                                                   <td>Yes</td>
                                                   <td>Pending</td>
                                                   <td><a data-bs-toggle="modal" data-bs-target="#empdetails"
                                                    href="">click</td>
                                                   <td><a data-bs-toggle="modal" data-bs-target="#clearnsdetailsAccount"
                                                    href="">form click</a> <a href="{{route('teamclear')}}">details</a> </td>
                                                   </tr>
                                                </tbody>
                                            </table>
                        </div>
                    </div>
                    </div>
                        </div>
				@include('employee.footerbottom')

            </div>
        </div>
    </div>
    <div class="modal fade show" id="empdetails" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">D Chandra Reddy Sekhara Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Designation: <span>Area Sales Coordinator</span></b></li>
                            <li> <b> Location:	 <span>Jaipur</span></b></li>
                            <li> <b> Qualification:	 <span>M.Sc</span></b></li>
                            <li> <b> VNR Exp.:	<span> 4.2 year</span></b></li>
                            <li> <b> Reporting Mgr:	 <span>Mr. Dinesh Swami</span></b></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                            <li> <b> DOJ: <span>01-10-2020</span></b></li>
                            <li> <b> Age: <span>31.1 year</span></b></li>
                            <li> <b> Total Exp.: <span>10.22 year</span></b></li>
                            <li> <b> Reviewer: <span>Mr. Dinesh Swami</span></b></li>
                        </ul>
                    </div>
                </div>

                <h5>Career Progression in VNR</h5>
                <table class="table table-bordered mt-2">
                    <thead style="background-color:#cfdce1;">
                        <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Designation</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                        </tr>
                    </tbody>
                </table>

                <h5>Previous Employers</h5>
                <table class="table table-bordered mt-2">
                    <thead style="background-color:#cfdce1;">
                        <tr>
                            <th>SN</th>
                            <th>Company</th>
                            <th>Designation</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                        </tr>
                    </tbody>
                </table>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade show" id="clearnsdetailsLOGISTIC" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (Logistic)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Designation: <span>Area Sales Coordinator</span></b></li>
                           
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                        </ul>
                    </div>
                </div>

                
                               
                <form>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Handover of Data Documents etc</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>2. Handover of ID Card</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>3. Complete of pending task</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>4. Handover of Health Card</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <h5 style="border-bottom: 1px solid #ddd;    margin-bottom: 10px;">Parties Clearance <a class="effect-btn btn btn-success squer-btn sm-btn">Add <i class="fas fa-plus mr-2"></i></a></h5>
                    <div class="clformbox">
                        <div class="formlabel">
                            <input style="width:100%;" class="form-control mb-2" type="text"  placeholder="Enter your parties name"><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <input style="width:100%;" class="form-control mb-2" type="text"  placeholder="Enter your parties name"><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div>
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="" placeholder="if any remarks enter here">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
               
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-success" type="submit">Final Submit</button>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade show" id="clearnsdetailsIT" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (IT)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Designation: <span>Area Sales Coordinator</span></b></li>
                           
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                        </ul>
                    </div>
                </div>

                
                               
                <form>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Sim Submitted</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>2. Company Handset Submitted</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>3. Laptop / Desktop Handover</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>4. Camera Submitted</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>5. Datacard Submitted</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <h5 style="border-bottom: 1px solid #ddd;    margin-bottom: 10px;">Id's Passward</h5>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>6. Email Account Blocked</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>7. Mobile No. Disabled Transfered</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <input style="width:100%;" class="form-control mb-2" type="text"  placeholder="Enter your parties name"><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                        <input class="form-control" type="text" name="" placeholder="Enter recovory ammount">
                        </div>
                        <div class="clreremarksbox">
                        <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <a class="effect-btn btn btn-success squer-btn sm-btn">Add <i class="fas fa-plus mr-2"></i></a>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="" placeholder="if any remarks enter here">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-success" type="submit">Final Submit</button>
            </div>
            
        </div>
    </div>
</div>



<div class="modal fade show" id="clearnsdetailsAccount" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (Account)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-3 emp-details-sep">
                    <div class="col-md-6">
                        <ul>
                            <li><b> Name: <span>D Chandra Reddy Sekhara</span></b></li>
                            <li> <b> Designation: <span>Area Sales Coordinator</span></b></li>
                           
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <li><b> Employee Code: <span>145</span></b></li>
                            <li> <b> Department:	 <span>Sales</span></b></li>
                        </ul>
                    </div>
                </div>

                
                               
                <form>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>1. Expences Claim Pending</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>2. Investment Proofs Submited</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                        
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>3. Advance Amount Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>4. Salary Advance Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>5. White Goods Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                  
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>6. Service Bond</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>7. TDS Adjustments</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <label style="width:100%;"><b>8. Recovery</b></label><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control mt-2" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>
                    
                    <div class="clformbox">
                        <div class="formlabel" style="width:40%;">
                            <input style="width:100%;" class="form-control mb-2" type="text"  placeholder="Enter your parties name"><br>
                            <input type="radio" name="docdata"><label>NA</label>
                            <input type="radio" name="docdata"><label>Yes</label>
                            <input type="radio" name="docdata"><label>No</label>
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Deduct</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Deduct Amount">
                        </div>
                        <div class="clrecoveramt" style="width:26%;">
                            <label style="width:100%;"><b>Earning</b></label><br>
                            <input class="form-control" type="text" name="" placeholder="Enter Earning Amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="" placeholder="Enter remarks">
                        </div>
                    </div>

                    <a class="effect-btn btn btn-success squer-btn sm-btn">Add <i class="fas fa-plus mr-2"></i></a>
                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="" placeholder="if any remarks enter here">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Save as Draft</button>
                <button class="btn btn-success" type="submit">Final Submit</button>
            </div>
            
        </div>
    </div>
</div>

@include('employee.footer');
<script>
    const employeeId = {{ Auth::user()->EmployeeID }};
	const repo_employeeId = {{ Auth::user()->EmployeeID }};
	const deptQueryUrl = "{{ route('employee.deptqueriesub') }}";
	const queryactionUrl = "{{ route("employee.query.action") }}";
	const getqueriesUrl = "{{ route("employee.queries") }}";

</script>
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>