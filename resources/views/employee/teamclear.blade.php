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
                                    <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">My Team - Clearance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Revanue Status Start -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="float-start"><b>D Chandra Reddy Sekhara Details</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row emp-details-sep">
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
                    </div>
                </div>

                <div class="row">
                    <div class="mfh-machine-profile">
                        <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link " id="Hr_tab"
                                    data-bs-toggle="tab" href="#HRTab" role="tab"
                                    aria-controls="HRTab" aria-selected="false">HR Clearance Form</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link active" id="logistic_tab"
                                    data-bs-toggle="tab" href="#logisticTab" role="tab"
                                    aria-controls="logisticTab" aria-selected="false">Logistic Clearance Form</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link " id="it_tab"
                                    data-bs-toggle="tab" href="#ITTab" role="tab"
                                    aria-controls="ITTab" aria-selected="false">IT Clearance Form</a>
                            </li>
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link " id="account_tab"
                                    data-bs-toggle="tab" href="#accountTab" role="tab"
                                    aria-controls="accountTab" aria-selected="false">Account Clearance Form</a>
                            </li>
                        </ul>
                        <div class="tab-content ad-content2" id="myTabContent2">
                            <div class="tab-pane fade" id="HRTab" role="tabpanel">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="float-start"><b>HR Clearance Form</b></h5>
                                        <div class="float-end" style="margin-top:-57px;">
                                            <ul class="kra-btns">
                                                <li><a class="effect-btn btn btn-success squer-btn sm-btn">Save as Draft</a></li>
                                                <li class="mt-1"><a class="mykraedit">Edit <i class="fas fa-edit mr-2"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <form class="row">
                                            <div class="col-md-4 form-group">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Earnings(Rs.)</h5>
                                                    </div>
                                                    <div class="card-body table-responsive">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Basic</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>HRA</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Car Allowance</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Bonus</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Special Allow</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>LTA</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Medical Allow.</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your amount" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Child Edu. Allow.</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your rate" id="firstNameinput">
                                                        </div>
                                                        <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                            <div class="col-md-4 form-group">
                                                <div class="card">
                                                    <div class="card-header">
                                                <h4>Annual Components</h4>
                                                    </div>
                                                    <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Leave Encashment</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Bonus Annual</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Bonus Adjustments</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Gratuity</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Mediclaim Expense</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Exgretia</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Notice Pay</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Total Earning</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                            </div>
                                        </div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5>Days</h5>
                                                    </div>
                                                    <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Total Salaried Days</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Actual Notice Peried(Days)</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Served Notice Peried(Days)</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Recoverable Notice Peried(Days)</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Available EL(Days)</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Encashable EL(Days)</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="col-md-4 form-group">
                                                <div class="card">
                                                    <div class="card-header">
                                                    <h5>Deduction Amount(Rs.)</h5>
                                                    </div>
                                                    <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>PF Amount</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>ESIC</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Arrear For Esic</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Recovery Towards Service Bond</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>Total Deduction</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="firstNameinput" class="form-label"><b>HR Remarks</b></label>
                                                    <input type="text" class="form-control" placeholder="Enter your firstname" id="firstNameinput">
                                                </div>
                                            </div></div></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="logisticTab" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-start"><b>Logistic Clearance Form</b></h5>
                                <div class="float-end" style="margin-top:-57px;">
                                    <ul class="kra-btns">
                                        <li><a class="effect-btn btn btn-success squer-btn sm-btn">Save as Draft</a></li>
                                        <li class="mt-1"><a class="mykraedit">Edit <i class="fas fa-edit mr-2"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <form>
                                    <div class="clformbox">
                                        <div class="formlabel">
                                            <label style="width:100%;"><b>1. Handover of Data Documents etc</b></label><br>
                                            <input type="radio" name="docdata"><label>NA</label>
                                            <input type="radio" name="docdata"><label>Yes</label>
                                            <input type="radio" name="docdata"><label>No</label>
                                        </div>
                                        <div class="clrecoveramt">
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                        </div>
                            </div>
                        <div class="tab-pane fade " id="accountTab" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-start"><b>Account Clearance Form</b></h5>
                                <div class="float-end" style="margin-top:-57px;">
                                    <ul class="kra-btns">
                                        <li><a class="effect-btn btn btn-success squer-btn sm-btn">Save as Draft</a></li>
                                        <li class="mt-1"><a class="mykraedit">Edit <i class="fas fa-edit mr-2"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
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
                        </div>
                    </div>
                    <div class="tab-pane fade " id="ITTab" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-start"><b>Departmental NOC Clearance Form (IT)</b></h5>
                                <div class="float-end" style="margin-top:-57px;">
                                    <ul class="kra-btns">
                                        <li><a class="effect-btn btn btn-success squer-btn sm-btn">Save as Draft</a></li>
                                        <li class="mt-1"><a class="mykraedit">Edit <i class="fas fa-edit mr-2"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body table-responsive">
                                <form>
                                    <div class="clformbox">
                                        <div class="formlabel">
                                            <label style="width:100%;"><b>1. Sim Submitted</b></label><br>
                                            <input type="radio" name="docdata"><label>NA</label>
                                            <input type="radio" name="docdata"><label>Yes</label>
                                            <input type="radio" name="docdata"><label>No</label>
                                        </div>
                                        <div class="clrecoveramt">
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                                        <input class="form-control" type="text" name="" placeholder="Enter recovery ammount">
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
                        </div>
                    </div>
                        </div>
                </div>
				@include('employee.footerbottom')
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
