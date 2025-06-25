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
                                    <li class="breadcrumb-link active">My Team - Clearance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Revanue Status Start -->
              

                <div class="row">
                    <div class="mfh-machine-profile">
                        <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
                           
                            <li class="nav-item">
                                <a style="color: #0e0e0e;" class="nav-link active " id="account_tab"
                                    data-bs-toggle="tab" href="#accountTab" role="tab"
                                    aria-controls="accountTab" aria-selected="false">Account Clearance Form</a>
                            </li>
                           
                        </ul>
                        <div class="tab-content ad-content2" id="myTabContent2">
                           
                            <div class="tab-pane fade show active " id="accountTab" role="tabpanel">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><b>Account NOC Clearance Form</b></h5>
                                    
                                    <a href="{{ route('export.approvedEmployeesacc') }}" style="font-size: 15px; color:black;">
                                        <i class="fas fa-file-excel"></i> Export
                                    </a>
                                </div>

                                     <div class="card-body table-responsive">
                                    <!-- IT Clearance Table -->
                                    <table class="table table-bordered" id="accttable">
                                        <thead style="background-color:#cfdce1;">
                                            <tr>
                                                <th>SN</th>
                                                <th>EC</th>
                                                <th>Employee Name</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Resignation Date</th>
                                                <th>Relieving Date</th>
                                                <th>Resignation Approved</th>
                                                <th colspan="5">Clearance Status</th>  <!-- Span 5 columns for Clearance Status -->
                                                <th>Clearance form</th>
                                            </tr>
                                            <tr>
                                                <!-- Subheaders for Clearance Status -->
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Department NOC Status</th>
                                                <th>Log NOC Status</th>
                                                <th>IT NOC Status</th>
                                                <th>HR NOC Status</th>
                                                <th>Account NOC Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($approvedEmployees as $index => $data)
                                                @php
                                                    // Check if status matches the query filter
                                                    $matchesStatus = true;
                                                    if (request('status') && !in_array(request('status'), ['Pending', 'Drafting', 'Submitted'])) {
                                                        $matchesStatus = false;
                                                    }

                                                    // If a status is selected, filter by status
                                                    if (request('status') && $data->Acc_NOC != request('status')) {
                                                        $matchesStatus = false;
                                                    }

                                                @endphp
                                                @if($matchesStatus)
                                                  
                                                        <tr>
                                                        <td>{{ $index + 1 }}.</td>
                                                        <td>{{ $data->EmpCode }}</td>
                                                        <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td>
                                                        <td>{{ $data->department_name }}</td>
                                                        <td>{{ $data->EmailId_Vnr }}</td>
                                                        <td>{{ $data->Emp_ResignationDate ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y') : 'Not specified' }}</td>
                                                        <td>{{ $data->Emp_RelievingDate ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y') : 'Not specified' }}</td>
                                                        <td>
                                                            <span class="{{ $data->Rep_Approved == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->Rep_Approved == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->Department_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->Department_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->Log_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->Log_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->IT_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->IT_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->HR_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->HR_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        
                                                    <td>
                                                    <span class="{{ $data->Acc_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                        @if($data->Acc_NOC == 'Y')
                                                            Approved
                                                        @elseif($data->Acc_NOC == 'N')
                                                            @php
                                                                // Fetch the record from the hrm_employee_separation_nocacc table using EmpSepId
                                                                $nocRecord = \DB::table('hrm_employee_separation_nocacc')->where('EmpSepId', $data->EmpSepId)->first();
                                                            @endphp

                                                            @if($nocRecord && $nocRecord->draft_submit_acct === 'Y')
                                                                Draft
                                                            @else
                                                                Pending
                                                            @endif
                                                        @endif
                                                    </span>
                                                </td>



                                                        @php
                                                            // Check if the resignation date is in the current year
                                                            $resignationYear = \Carbon\Carbon::parse($data->Emp_ResignationDate)->year;
                                                            $currentYear = \Carbon\Carbon::now()->year;
                                                        @endphp
                                                            @if($data->HR_NOC === 'Y')
                                                            <td>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsAcct"
                                                            data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}"
                                                            data-designation="{{ $data->designation_name }}"
                                                            data-emp-code="{{ $data->EmpCode }}"
                                                            data-department="{{ $data->department_name }}"
                                                            data-employee-id="{{ $data->EmployeeID }}"
                                                            data-emp-sepid="{{ $data->EmpSepId }}">
                                                            Form click
                                                            </a>
                                                        </td>
                                                        @else
                                                                <td></td> <!-- Empty cell for alignment -->
                                                            @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                </div>

                               

                                </div>
                            </div>
                    </div>
                </div>
				@include('employee.footerbottom')
            </div>
        </div>
    </div>
          
            <div class="modal fade show" id="clearnsdetailsAcct" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form(Account)</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>

                            </div>
                            <div class="modal-body">
                            <div class="row mb-3 emp-details-sep">
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li><b> Name: <span class="emp-name"></span></b></li>
                                                        <li> <b> Designation: <span class="designation"></span></b></li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul>
                                                        <li><b> Employee Code: <span class="emp-code"></span></b></li>
                                                        <li> <b> Department: <span class="department"></span></b></li>
                                                    </ul>
                                                </div>
                                            </div>
                                <!-- Tab Navigation -->
                                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="hr-tab" data-bs-toggle="tab" href="#hr" role="tab" aria-controls="hr" aria-selected="true">HR Clearance Form</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="logistics-tab" data-bs-toggle="tab" href="#logistics" role="tab" aria-controls="logistics" aria-selected="false">Logistics/Departmental Clearance Form</a>
                                    </li>
                                    
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="it-tab" data-bs-toggle="tab" href="#it" role="tab" aria-controls="it" aria-selected="false">IT Clearance Form</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="acct-tab" data-bs-toggle="tab" href="#acct" role="tab" aria-controls="acct" aria-selected="false">Account Clearance Form</a>
                                    </li>
                                </ul>
                            

                                <!-- Tab Content -->
                                <div class="tab-content" id="myTabContent">
                                    <!-- HR Tab -->
                                    <div class="tab-pane fade show active" id="hr" role="tabpanel" aria-labelledby="hr-tab">
                                    <button id="revertBackButton" style="margin:5px;float:inline-end; padding: 5px 10px; font-size: 10px; background-color: #c4d9db; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; color: #333;">
                                            Revert Back
                                        </button>
                                    <form id="hrnocfrom" method="POST">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">
                                            <input type="hidden" name="EmployeeID">

                    
                                        <div class="clformbox">
                                        <div class="formlabel" style="display: flex; align-items: center;">
                                                <label style="width: auto; margin-right: 10px;"><b>1. Block ESS Passward</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="block_ess_passward[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="block_ess_passward[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="block_ess_passward[]" value="No"> No
                                                        </label>
                                                    </div>
                                                    </div>


                                            <div class="clrecoveramt">
                                                <input class="form-control" type="text" name="block_ess_passward_recovery_amount" placeholder="Enter recovery amount">
                                            </div>
                                            <div class="clreremarksbox">
                                                <input class="form-control" type="text" name="block_ess_passward_remarks" placeholder="Enter remarks" style="margin:10px;">
                                            </div>
                                        </div>
                    
                                        <div class="clformbox">
                                        <div class="formlabel" style="display: flex; align-items: center;">
                                                <label style="width: auto; margin-right: 10px;"><b>2. Block Paypac Passward</b></label>
                                                <div style="display: flex; align-items: center;">
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="block_paypac_passward[]" value="NA"> NA
                                                    </label>
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="block_paypac_passward[]" value="Yes"> Yes
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="block_paypac_passward[]" value="No"> No
                                                    </label>
                                                </div>
                                                </div>

                                            <div class="clrecoveramt">
                                                <input class="form-control" type="text" name="block_paypac_passward_recovery_amount" placeholder="Enter recovery amount">
                                            </div>
                                            <div class="clreremarksbox">
                                                <input class="form-control" type="text" name="block_paypac_passward_remarks" placeholder="Enter remarks" style="margin:10px;">
                                            </div>
                                        </div>
                    
                                        <div class="clformbox">
                                        <div class="formlabel" style="display: flex; align-items: center;">
                                                <label style="width: auto; margin-right: 10px;"><b>3. Block Expro Passward</b></label>
                                                <div style="display: flex; align-items: center;">
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="block_expro_passward[]" value="NA"> NA
                                                    </label>
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="block_expro_passward[]" value="Yes"> Yes
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="block_expro_passward[]" value="No"> No
                                                    </label>
                                                </div>
                                                </div>

                                            <div class="clrecoveramt">
                                                <input class="form-control" type="text" name="block_expro_passward_recovery_amount" placeholder="Enter recovery amount">
                                            </div>
                                            <div class="clreremarksbox">
                                                <input class="form-control" type="text" name="block_expro_passward_remarks" placeholder="Enter remarks" style="margin:10px;">
                                            </div>
                                        </div>
                    
                                        <div class="clformbox">
                                            <div class="formlabel">
                                                <label style="width:100%;"><b>4. ID Card Submitted</b></label><br>
                                                <input type="checkbox" name="id_card_submitted[]" value="NA"><label>NA</label>
                                                <input type="checkbox" name="id_card_submitted[]" value="Yes"><label>Yes</label>
                                                <input type="checkbox" name="id_card_submitted[]" value="No"><label>No</label>
                                            </div>
                                            <div class="clrecoveramt">
                                                <input class="form-control" type="text" name="id_card_recovery_amount" placeholder="Enter recovery amount">
                                            </div>
                                            <div class="clreremarksbox">
                                                <input class="form-control" type="text" name="id_card_remarks" placeholder="Enter remarks">
                                            </div>
                                        </div>
                    
                                        <div class="clformbox">
                                        <div class="formlabel" style="display: flex; align-items: center;">
                                                <label style="width: auto; margin-right: 10px;"><b>5. Visiting Card Submitted</b></label>
                                                <div style="display: flex; align-items: center;">
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="visiting_submitted[]" value="NA"> NA
                                                    </label>
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="visiting_submitted[]" value="Yes"> Yes
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="visiting_submitted[]" value="No"> No
                                                    </label>
                                                </div>
                                                </div>

                                            <div class="clrecoveramt">
                                                <input class="form-control" type="text" name="visiting_recovery_amount" placeholder="Enter recovery amount">
                                            </div>
                                            <div class="clreremarksbox">
                                                <input class="form-control" type="text" name="visiting_remarks" placeholder="Enter remarks"style="margin:10px;">
                                            </div>
                                        </div> 
                    
                                        <div class="clformbox">
                                        <div class="formlabel" style="display: flex; align-items: center;">
                                                <label style="width: auto; margin-right: 10px;"><b>5. Company Vehicle Return</b></label>
                                                <div style="display: flex; align-items: center;">
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="company_vehicle_return[]" value="NA"> NA
                                                    </label>
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="company_vehicle_return[]" value="Yes"> Yes
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="company_vehicle_return[]" value="No"> No
                                                    </label>
                                                </div>
                                                </div>

                                            <div class="clrecoveramt">
                                                <input class="form-control" type="text" name="company_vehcile_recovery_amount" placeholder="Enter recovery amount">
                                            </div>
                                            <div class="clreremarksbox">
                                                <input class="form-control" type="text" name="company_vehcile_remarks" placeholder="Enter remarks"style="margin:10px;">
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-7 mb-2"><label><b>Worked Days Without Notice Period</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="worked_days_without_notice" placeholder="Enter"></div>
                    
                                                    <div class="col-md-7 mb-2"><label><b>Served Notice Period (Days)</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="served_notice_period" placeholder="Enter"></div>
                    
                                                    <div class="col-md-7 mb-2"><label><b>Available EL(Days)</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="available_el_days" placeholder="Enter"></div>
                    
                                                    <div class="col-md-7 mb-2"><label><b>Total Number of Worked(Salaried Days)</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="total_worked_days" placeholder="Enter"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-7 mb-2"><label><b>Actual Notice Period(Days)</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="actual_notice_period" placeholder="Enter"></div>
                    
                                                    <div class="col-md-7 mb-2"><label><b>Recoverable Notice Period (Days)</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="recoverable_notice_period" placeholder="Enter"></div>
                    
                                                    <div class="col-md-7 mb-2"><label><b>Encashable EL(Days)</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="encashable_el_days" placeholder="Enter"></div>
                    
                                                    <div class="col-md-7 mb-2"><label><b>Partially Amount Paid</b></label></div>
                                                    <div class="col-md-5 mb-2"><input class="form-control" type="text" name="partially_amount_paid" placeholder="Enter"></div>
                                                </div>
                                            </div>
                                        </div>
                    
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><b>Earnings(Rs.)</b></h5>
                                            </div>
                                            <div class="row card-body table-responsive">
                                                <div class="col-md-6 mb-3">
                                                    <label for="basicRate" class="form-label"><b>Basic</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="basicRate" name="basic_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="basicAmount" name="basic_amount">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="hraRate" class="form-label"><b>HRA</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="hraRate" name="hra_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="hraAmount" name="hra_amount">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="carAllowanceRate" class="form-label"><b>Car Allowance</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="carAllowanceRate" name="car_allowance_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="carAllowanceAmount" name="car_allowance_amount">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="bonusRate" class="form-label"><b>Bonus</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="bonusRate" name="bonus_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="bonusAmount" name="bonus_amount">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="specialAllowRate" class="form-label"><b>Special Allow</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="specialAllowRate" name="special_allow_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="specialAllowAmount" name="special_allow_amount">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="dailyallowance" class="form-label"><b>Daily Allow</b></label>
                                                    <div class="row">
                                                        <!-- <div class="col-md-6">
                                                            <input type="number" class="form-control" id="dailyallowancerate" name="dailyallowance">
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" id="dailyallowance" name="dailyallowance">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="monthlygross" class="form-label"><b>Monthly Gross</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" id="monthlygrossrate" name="monthlygrossrate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" id="monthlygrossamt" name="monthlygrossamt">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="ltaRate" class="form-label"><b>LTA</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="ltaRate" name="lta_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="ltaAmount" name="lta_amount">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="medicalAllowRate" class="form-label"><b>Medical Allow.</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="medicalAllowRate" name="medical_allow_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="medicalAllowAmount" name="medical_allow_amount">
                                                        </div>
                                                    </div>
                                                </div>
                    
                                                <div class="col-md-6 mb-3">
                                                    <label for="childEduAllowRate" class="form-label"><b>Child Edu. Allow.</b></label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your rate" id="childEduAllowRate" name="child_edu_allow_rate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="number" class="form-control" placeholder="Enter your amount" id="childEduAllowAmount" name="child_edu_allow_amount">
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><b>Annual Components</b></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <!-- Leave Encashment -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="leaveencash" class="form-label"><b>Leave Encashment</b></label>
                                                        <input type="text" class="form-control" id="leaveencash" name="leaveencash">
                                                    </div>

                                                    <!-- Bonus Annual -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="bonusannual" class="form-label"><b>Bonus Annual</b></label>
                                                        <input type="text" class="form-control" id="bonusannual" name="bonusannual">
                                                    </div>

                                                    <!-- Bonus Adjustment -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="bonusadjst" class="form-label"><b>Bonus Adjustment</b></label>
                                                        <input type="text" class="form-control" id="bonusadjst" name="bonusadjst">
                                                    </div>

                                                    <!-- Gratuity -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="gratuity" class="form-label"><b>Gratuity</b></label>
                                                        <input type="text" class="form-control" id="gratuity" name="gratuity">
                                                    </div>

                                                    <!-- Mediclaim Expense -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="mediclaim" class="form-label"><b>Mediclaim Expense</b></label>
                                                        <input type="text" class="form-control" id="mediclaim" name="mediclaim">
                                                    </div>

                                                    <!-- Exgretia -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="exgretia" class="form-label"><b>Exgratia</b></label>
                                                        <input type="text" class="form-control" id="exgretia" name="exgretia">
                                                    </div>

                                                    <!-- Notice Pay -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="noticepay" class="form-label"><b>Notice Pay</b></label>
                                                        <input type="text" class="form-control" id="noticepay" name="noticepay">
                                                    </div>

                                                    <!-- Total Earnings -->
                                                    <div class="mb-3 col-md-6">
                                                        <label for="totearn" class="form-label"><b>Total Earning:</b></label>
                                                        <input type="text" class="form-control" id="totearn" name="totearn" disabled> <!-- Disabled to show calculated value -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                    
                                        <div class="card">
                                            <div class="card-header">
                                                <h5><b>Deduction Amount(Rs.)</b></h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label for="pfAmount" class="form-label"><b>PF Amount</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter PF Amount" id="pfAmount" name="pf_amount">
                                                    </div>
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="esic" class="form-label"><b>ESIC</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter ESIC Amount" id="esic" name="esic">
                                                    </div>
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="arrearEsic" class="form-label"><b>Arrear For Esic</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Arrear For ESIC" id="arrearEsic" name="arrear_esic">
                                                    </div>
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="serviceBondRecovery" class="form-label"><b>Recovery Towards Service Bond</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Recovery Towards Service Bond" id="serviceBondRecovery" name="service_bond_recovery">
                                                    </div>
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="noticePeriodRecovery" class="form-label"><b>Notice Period Recovery</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Notice Period Recovery" id="noticePeriodRecovery" name="notice_period_recovery">
                                                    </div>
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="noticePeriodAmount" class="form-label"><b>Notice Period Amount</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Notice Period Amount" id="noticePeriodAmount" name="notice_period_amount">
                                                    </div>
                    
                                                    <!-- <div class="mb-3 col-md-6">
                                                        <label for="voluntaryContribution" class="form-label"><b>Voluntary Contribution</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Voluntary Contribution" id="voluntaryContribution" name="voluntary_contribution">
                                                    </div> -->
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="relocationAllowance" class="form-label"><b>ReLocation Allowance</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Relocation Allowance" id="relocationAllowance" name="relocation_allowance">
                                                    </div>
                    
                                                    <!-- <div class="mb-3 col-md-6">
                                                        <label for="nrsDeduction" class="form-label"><b>NRS Deduction</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter NRS Deduction" id="nrsDeduction" name="nrs_deduction">
                                                    </div> -->
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="totalDeduction" class="form-label"><b>Total Deduction</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Total Deduction" id="totalDeduction" name="total_deduction">
                                                    </div>
                    
                                                    <div class="mb-3 col-md-6">
                                                        <label for="hrRemarks" class="form-label"><b>HR Remarks</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter HR Remarks" id="hrRemarks" name="hr_remarks">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- HR-specific action buttons -->
                                        <!-- <div class="modal-footer">
                                            <button class="btn btn-primary" type="button" id="save-draft-btn-hr">Save as Draft</button>
                                            <button class="btn btn-success" type="button" id="final-submit-btn-hr">Final Submit</button>
                                        </div> -->
                                    </form>
                                    </div>

                                    <!-- Logistics Tab -->
                                    <div class="tab-pane fade" id="logistics" role="tabpanel" aria-labelledby="logistics-tab">
                                        <form id="logisticsnocform">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">
                                            <input type="hidden" name="EmployeeID">


                                                <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                <label style="width: auto; margin-right: 10px;"><b>1. Handover of Data Documents etc</b></label>
                                                <div style="display: flex; align-items: center;">
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="DDH[]" value="NA"> NA
                                                    </label>
                                                    <label style="margin-right: 10px;">
                                                        <input type="checkbox" name="DDH[]" value="Yes"> Yes
                                                    </label>
                                                    <label>
                                                        <input type="checkbox" name="DDH[]" value="No"> No
                                                    </label>
                                                </div>
                                            </div>

                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="text" name="DDH_Amt" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="DDH_Remark" placeholder="Enter remarks"style="margin:10px;">
                                                </div>
                                                </div>

                                                <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>2. Handover of ID Card</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="TID[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="TID[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="TID[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="text" name="TID_Amt" placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="TID_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>3. Complete pending task</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="APTC[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="APTC[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="APTC[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="text" name="APTC_Amt" placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="APTC_Remark" placeholder="Enter remarks" style="margin:10px;">
                                                    </div>
                                                </div>

                                                <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>4. Handover of Health Card</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="HOAS[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="HOAS[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="HOAS[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                    <div class="clrecoveramt">
                                                        <input class="form-control" type="text" name="HOAS_Amt" placeholder="Enter recovery amount">
                                                    </div>
                                                    <div class="clreremarksbox">
                                                        <input class="form-control" type="text" name="HOAS_Remark" placeholder="Enter remarks" style="margin:10px;">
                                                    </div>
                                                </div>

                                                <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
                                                Parties Clearance 
                                                <a class="effect-btn btn btn-success squer-btn sm-btn" id="add-more">
                                                    Add <i class="fas fa-plus mr-2"></i>
                                                </a>
                                            <div id="parties-container">
                                                <!-- Dynamically generated party sections will appear here -->
                                            </div>
                                            <div id="total-amount-log" style="margin:0px 60px 10px 0px; font-weight: bold;float:inline-end;"></div>


                                            <div class="clformbox">
                                                <div class="formlabel">
                                                    <label style="width:100%;"><b>Any remarks</b></label>
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="otherremark" placeholder="if any remarks enter here">
                                                </div>
                                            </div>
                                        

                                        
                                            <!-- Logistics-specific action buttons -->
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" id="save-draft-btn-log">Save as Draft</button>
                                                <button class="btn btn-success" type="button" id="final-submit-btn-log">Final Submit</button>
                                            </div>
                                        </form>

                                    </div>

                                    <!-- IT Tab -->
                                    <div class="tab-pane fade" id="it" role="tabpanel" aria-labelledby="it-tab"> 
                                        <form id="itnocform">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">
                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>1. Sim Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="sim_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="sim_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="sim_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="sim_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="sim_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>2. Company Handset Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="handset_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="handset_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="handset_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="handset_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="handset_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>3. Laptop / Desktop Handover</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="laptop_handover[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="laptop_handover[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="laptop_handover[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="laptop_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="laptop_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>4. Camera Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="camera_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="camera_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="camera_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="camera_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="camera_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>5. Datacard Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="datacard_submitted[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="datacard_submitted[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="datacard_submitted[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="datacard_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="datacard_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">ID's Password</h5>
                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>6. Email Account Blocked</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="email_blocked[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="email_blocked[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="email_blocked[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="email_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="email_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>7. Mobile No. Disabled/Transferred</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="mobile_disabled[]" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="mobile_disabled[]" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="mobile_disabled[]" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="clrecoveramt">
                                                    <input class="form-control" type="number" name="mobile_recovery_amount" placeholder="Enter recovery amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control" type="text" name="mobile_remarks" placeholder="Enter remarks">
                                                </div>
                                            </div>
                                            <div id="total-amount-it" style="margin:0px 60px 10px 0px; font-weight: bold;float:inline-end;"></div>


                                            <div class="clformbox">
                                                <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: 100%;"><b>Any remarks</b></label>
                                                </div>
                                                <div>
                                                    <input class="form-control" type="text" name="any_remarks" placeholder="If any remarks enter here">
                                                </div>
                                            </div>

                                            <!-- IT-specific action buttons -->
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" id="save-draft-btn-it">Save as Draft</button>
                                                <button class="btn btn-success" type="button" id="final-submit-btn-it">Final Submit</button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Account Tab -->
                                    <div class="tab-pane fade" id="acct" role="tabpanel" aria-labelledby="acct-tab">
                                        
                                        <form id="acctnocform" method="POST">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">

                                            <div class="clformbox">
                                            <div class="formlabel" style="width:40%; display: flex; align-items: center">
                                            <label style="width: auto; margin-right: 10px;"><b>1. Expenses Claim Pending</b></label>
                                            <div style="display: flex; align-items: center;">
                                                <label style="margin-right: 10px;">
                                                    <input type="checkbox" name="AccECP" value=""> NA
                                                </label>
                                                <label style="margin-right: 10px;">
                                                    <input type="checkbox" name="AccECP" value="Y"> Yes
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="AccECP" value="N"> No
                                                </label>
                                            </div>
                                        </div>

                                            <div class="clrecoveramt" style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                <div style="flex: 1;">
                                                    <label><b>Earning</b></label><br>
                                                    <input class="form-control" type="number" name="AccECP_Amt" placeholder="Enter Earning Amount">
                                                </div>
                                                <div style="flex: 1;">
                                                    <label><b>Deductions</b></label><br>
                                                    <input class="form-control" type="number" name="AccECP_Amt2" placeholder="Enter Deduct Amount">
                                                </div>
                                                <div style="flex: 1;">
                                                    <label><b>Remarks</b></label><br>
                                                    <input class="form-control" type="text" name="AccECP_Remark" placeholder="Enter remarks">
                                                </div>
                                            </div>

                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>2. Investment Proofs Submitted</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccIPS" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccIPS" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccIPS" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccIPS_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deduction</b></label><br>
                                                        <input class="form-control" type="number" name="AccIPS_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccIPS_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>3. Advance Amount Recovery</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccAMS" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccAMS" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccAMS" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccAMS_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deduction</b></label><br>
                                                        <input class="form-control" type="number" name="AccAMS_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccAMS_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>4. Salary Advance Recovery</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccSAR" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccSAR" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccSAR" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccSAR_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deductions</b></label><br>
                                                        <input class="form-control" type="number" name="AccSAR_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccSAR_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>5. White Goods Recovery</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccWGR" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccWGR" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccWGR" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccWGR_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deductions</b></label><br>
                                                        <input class="form-control" type="number" name="AccWGR_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccWGR_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>6. Service Bond</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccSB" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccSB" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccSB" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccSB_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deductions</b></label><br>
                                                        <input class="form-control" type="number" name="AccSB_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccSB_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>7. TDS Adjustments</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccTDSA" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccTDSA" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccTDSA" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccTDSA_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deduction</b></label><br>
                                                        <input class="form-control" type="number" name="AccTDSA_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccTDSA_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clformbox">
                                                <div class="formlabel" style="width:40%; display: flex; align-items: center; margin-bottom: 10px;">
                                                    <label style="width: auto; margin-right: 10px;"><b>8. Recovery</b></label>
                                                    <div style="display: flex; align-items: center;">
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccRecy" value=""> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccRecy" value="Y"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccRecy" value="N"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccRecy_Amt" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Deduction</b></label><br>
                                                        <input class="form-control" type="number" name="AccRecy_Amt2" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccRecy_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>


                                           
                            
                                                <!-- <a class="effect-btn btn btn-success squer-btn sm-btn">Add <i class="fas fa-plus mr-2"></i></a> -->
                                                <div class="clformbox">
                                                    <div class="formlabel">
                                                        <label style="width:100%;"><b>Any remarks</b></label>
                                                    </div>
                                                    <div>
                                                        <input class="form-control" type="text" name="acct_remark" placeholder="if any remarks enter here">
                                                    </div>
                                                </div>

                                                <table id="overall-summary" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
                                                    <tr style="background-color: #f2f2f2; text-align: center;">
                                                        <td colspan="3" style="font-weight: bold; font-size: 18px; padding: 10px; border: 1px solid #ddd;">Overall Calculation</td>
                                                    </tr>

                                                    <!-- Header Row -->
                                                    <tr style="background-color: #f2f2f2; text-align: center;">
                                                        <td style="font-weight: bold; padding: 10px; border: 1px solid #ddd;">Total Clearance</td>
                                                        <td style="font-weight: bold; padding: 10px; border: 1px solid #ddd;">Earnings</td>
                                                        <td style="font-weight: bold; padding: 10px; border: 1px solid #ddd;">Deductions</td>
                                                    </tr>

                                                   <!-- IT Earnings and Deductions -->
                                                    <tr>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">IT</td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                        <input type="number" id="it-deductions" name="itdeductions" value="0" style="width: 100px;" readonly/>
                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="it-earnings" name="itearnings" value="0" style="width: 100px;" readonly />

                                                        </td>
                                                    </tr>

                                                    <!-- Logistics Earnings and Deductions -->
                                                    <tr>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">Reporting Manager </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                        <input type="number" id="logistics-deductions" name="logisticsdeductions" value="0" style="width: 100px;"readonly />

                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="logistics-earnings"  name="logisticsearnings" value="0" style="width: 100px;"readonly />

                                                        </td>
                                                    </tr>
                                                    <!-- hr Earnings and Deductions -->
                                                    <tr>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">HR</td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="hr-earnings" name="hrearnings" value="0" style="width: 100px;" readonly/>
                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="hr-deductions" name="hrdeductions" value="0" style="width: 100px;" readonly/>
                                                        </td>
                                                    </tr>

                                                    <!-- Account Earnings and Deductions -->
                                                    <tr>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">Account</td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="account-earnings" name="accountearnings" value="0" style="width: 100px;" readonly/>
                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="account-deductions" name="accountdeductions" value="0" style="width: 100px;" readonly/>
                                                        </td>
                                                    </tr>


                                                    <!-- Total Section -->
                                                    <tr style="background-color: #f2f2f2; text-align: center;">
                                                        <td style="font-weight: bold; padding: 10px; border: 1px solid #ddd;">Total Amount</td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;"  name="totalearnings" id="total-earnings"></td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;" name="totaldeductions" id="total-deductions"></td>
                                                    </tr>
                                                </table>
                                            <!-- Account-specific action buttons -->
                                            <div class="modal-footer">
                                                <button class="btn btn-primary" type="button" id="save-draft-btn-acct">Save as Draft</button>
                                                <button class="btn btn-success" type="button" id="final-submit-btn-acct">Final Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
            </div>



@include('employee.footer')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Automatically click the #hr-tab when the page loads

    document.getElementById('hr-tab').click();

    // Function to handle form submission
    const form = document.getElementById('hrnocfrom');
    const saveDraftButton = document.getElementById('save-draft-btn-it');
    const submitButton = document.getElementById('final-submit-btn-it');
    const partiesContainer = document.getElementById('it-parties-container');
    let partyCount = 1;

    // Function to handle form submission
    function handleFormSubmission(buttonId, event) {
        event.preventDefault();
        $('#loader').show();

        const formData = new FormData(form);
        formData.append('button_id', buttonId); // Add button id to track submission type

        // Send form data to the Laravel controller using fetch
        fetch("{{ route('submit.noc.clearance.hr') }}", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // Handle the response here (e.g., show success message)
                if (data.success) {
                    $('#loader').hide();

                    // Show a success toast notification with custom settings
                    toastr.success(data.message, 'Success', {
                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                    });

                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        location.reload();  // Optionally, reload the page
                    }, 3000); // Delay before reset and reload to match the toast timeout

                } else {
                    // Show an error toast notification with custom settings
                    toastr.error('Error: ' + data.message, 'Error', {
                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                    });
                }
            })
            .catch(error => {
                // Handle errors from the fetch request itself
                toastr.error('Error: ' + error.message, 'Error', {
                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                });
            });
    }

    // Trigger the AJAX call when the form (or button) is clicked
    $(document).ready(function() {
        $('#clearnsdetailsAcct').on('show.bs.modal', function () {

        $('#hr-tab').trigger('click');  // Simulate the click event for the HR tab
    });
        // Automatically trigger the click event for the #hr-tab
        $('#hr-tab').off('click').on('click', function () {
            var empSepId = $('input[name="EmpSepId"]').val();
            var employeeidhr = $('input[name="EmployeeID"]').val();

            // Fetch additional data for this EmpSepId using an AJAX request
            $.ajax({
                url: '/get-noc-data-hr/' + empSepId + '/' + employeeidhr,  // Correct structure
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var nocData = response.data; // Data returned from backend
                        var ctcData = response.ctc; // Data returned from backend

                        // Populate the form fields with the fetched data:

                        // Example: Checkboxes
                        $('input[name="block_ess_passward[]"][value="' + nocData.BEP + '"]').prop('checked', true);
                        $('input[name="block_paypac_passward[]"][value="' + nocData.BPP + '"]').prop('checked', true);
                        $('input[name="block_expro_passward[]"][value="' + nocData.BExP + '"]').prop('checked', true);
                        $('input[name="id_card_submitted[]"][value="' + nocData.AdminIC + '"]').prop('checked', true);
                        $('input[name="visiting_submitted[]"][value="' + nocData.AdminVC + '"]').prop('checked', true);
                        $('input[name="company_vehicle_return[]"][value="' + nocData.CV + '"]').prop('checked', true);

                        // Example: Text inputs
                        $('input[name="block_ess_passward_recovery_amount"]').val(nocData.BEP_Amt);
                        $('input[name="block_ess_passward_remarks"]').val(nocData.BEP_Remark);

                        $('input[name="block_paypac_passward_recovery_amount"]').val(nocData.BPP_Amt);
                        $('input[name="block_paypac_passward_remarks"]').val(nocData.BPP_Remark);

                        $('input[name="block_expro_passward_recovery_amount"]').val(nocData.BExP_Amt);
                        $('input[name="block_expro_passward_remarks"]').val(nocData.BExP_Remark);
                        $('input[name="id_card_recovery_amount"]').val(nocData.AdminIC_Amt);
                        $('input[name="id_card_remarks"]').val(nocData.AdminIC_Remark);

                        $('input[name="visiting_recovery_amount"]').val(nocData.AdminVC_Amt);
                        $('input[name="visiting_remarks"]').val(nocData.AdminVC_Remark);

                        $('input[name="company_vehcile_recovery_amount"]').val(nocData.CV_Amt);
                        $('input[name="company_vehcile_remarks"]').val(nocData.CV_Remark);

                        // Example: Worked days, notice period, etc.
                        $('input[name="worked_days_without_notice"]').val(nocData.WorkDay);
                        $('input[name="served_notice_period"]').val(nocData.ServedDay);
                        $('input[name="available_el_days"]').val(nocData.TotEL);
                        $('input[name="total_worked_days"]').val(nocData.TotWorkDay);
                        $('input[name="actual_notice_period"]').val(nocData.NoticeDay);
                        $('input[name="recoverable_notice_period"]').val(nocData.RecoveryDay);
                        $('input[name="encashable_el_days"]').val(nocData.EnCashEL);
                        $('input[name="partially_amount_paid"]').val(nocData.partially_amount_paid);

                        // Earnings section
                        $('input[name="basic_rate"]').val(ctcData.BAS_Value);
                        $('input[name="basic_amount"]').val(nocData.Basic);
                        $('input[name="hra_rate"]').val(ctcData.HRA_Value);
                        $('input[name="hra_amount"]').val(nocData.HRA);
                        $('input[name="car_allowance_rate"]').val(ctcData.CAR_ALL_Value);
                        $('input[name="car_allowance_amount"]').val(nocData.CarAllow);
                        $('input[name="bonus_rate"]').val(ctcData.Bonus_Month);
                        $('input[name="bonus_amount"]').val(nocData.Bonus_Month);
                        $('input[name="special_allow_rate"]').val(ctcData.SPECIAL_ALL_Value);
                        $('input[name="special_allow_amount"]').val(nocData.SA);

                        $('input[name="dailyallowance"]').val(nocData.DA);
                        $('input[name="monthlygrossrate"]').val(ctcData.GrossSalary_PostAnualComponent_Value);
                        $('input[name="monthlygrossamt"]').val(nocData.Gross);

                        $('input[name="lta_rate"]').val(Math.round(ctcData.LTA_Value / 12));
                        $('input[name="lta_amount"]').val(nocData.LTA);

                        $('input[name="medical_allow_rate"]').val(Math.round(ctcData.MED_REM_Value / 12));
                        $('input[name="medical_allow_amount"]').val(nocData.Mediclaim);

                        $('input[name="child_edu_allow_rate"]').val(Math.round(ctcData.CHILD_EDU_ALL_Value / 12));
                        $('input[name="child_edu_allow_amount"]').val(nocData.CEA);

                        $('input[name="leaveencash"]').val(nocData.LE);
                        $('input[name="bonusannual"]').val(nocData.Bonus);
                        $('input[name="bonusadjst"]').val(nocData.Bonus_Adjustment);
                        $('input[name="gratuity"]').val(nocData.Gratuity);
                        $('input[name="mediclaim"]').val(nocData.Mediclaim);
                        $('input[name="exgretia"]').val(nocData.Exgredia);
                        $('input[name="noticepay"]').val(nocData.NoticePay);
                        $('input[name="totearn"]').val(nocData.TotEar);

                        // Deduction section
                        $('input[name="pf_amount"]').val(nocData.PF);
                        $('input[name="esic"]').val(nocData.ESIC);
                        $('input[name="arrear_esic"]').val(nocData.ARR_ESIC);
                        $('input[name="service_bond_recovery"]').val(nocData.RTSB);
                        $('input[name="notice_period_recovery"]').val(nocData.NPR);
                        $('input[name="notice_period_amount"]').val(nocData.NoticePay);
                        $('input[name="voluntary_contribution"]').val(nocData.voluntary_contribution);
                        $('input[name="relocation_allowance"]').val(nocData.RA_allow);
                        $('input[name="nrs_deduction"]').val(nocData.nrs_deduction);
                        if (nocData.TotDeduct === "0.00") {
                            consoel.log('sXZXZ');
                                const totDeduct = 
                                    nocData.PF + 
                                    nocData.ESIC + 
                                    nocData.ARR_ESIC + 
                                    nocData.RTSB + 
                                    nocData.NPS_Ded + 
                                    nocData.NPR + 
                                    nocData.VolC + 
                                    nocData.RA_allow + 
                                    nocData.AdminIC_Amt + 
                                    nocData.AdminVC_Amt + 
                                    nocData.CV_Amt;
                                
                                // Set the calculated total deduction value
                                $('input[name="total_deduction"]').val(totDeduct.toFixed(2));
                            } 
                            else {
                                // Set the value from nocData.TotDeduct
                                $('input[name="total_deduction"]').val(nocData.TotDeduct);
                            }
                        $('input[name="hr_remarks"]').val(nocData.HrRemark);

                        // Update earnings and deductions
                        $('#hr-earnings').val(nocData.TotEar);
                        $('#hr-deductions').val(nocData.TotDeduct);
                    }
                },
                error: function () {
                    console.error('Error fetching NOC data.');
                }
            });
        });
    });
});



// acct starts
                document.addEventListener("DOMContentLoaded", function () {
                        const form = document.getElementById('acctnocform');
                        const saveDraftButton = document.getElementById('save-draft-btn-acct');
                        const submitButton = document.getElementById('final-submit-btn-acct');
                        // let partyCount = 1;

                        // Function to handle form submission
                        function handleFormSubmission(buttonId, event) {
                            event.preventDefault();
                            $('#loader').show();

                            const formData = new FormData(form);
                            formData.append('button_id', buttonId); // Add button id to track submission type


                             /*const totalEarnings = parseFloat($('#logistics-earnings').val()) + parseFloat($('#account-earnings').val()) + parseFloat($('#it-earnings').val()) + parseFloat($('#hr-earnings').val());
                                 const totalDeductions = parseFloat($('#account-deductions').val()) + parseFloat($('#logistics-deductions').val()) + parseFloat($('#it-deductions').val())+ parseFloat($('#hr-deductions').val());
                                 formData.append('total_earnings', totalEarnings.toFixed(0));  // Append total earnings
                                formData.append('total_deductions', totalDeductions.toFixed(0));  // Append total deductions*/

                                  var totalEarnings = document.getElementById('total-earnings').textContent;
                        var totaldeduction = document.getElementById('total-deductions').textContent;
                        formData.append('total_earnings', totalEarnings); // Append total earnings
                        formData.append('total_deductions', totaldeduction); // Append total deductions



                            // Send form data to the Laravel controller using fetch
                            fetch("{{ route('submit.noc.clearance.acct') }}", {
                                method: "POST",
                                body: formData,
                            })
                                .then(response => response.json())
                                .then(data => {
                                // Handle the response here (e.g., show success message)
                                if (data.success) {  // Use 'data' instead of 'response'
                                    $('#loader').hide();

                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                    if (buttonId === 'save-draft-btn-acct') {
                                                var empSepId = $('input[name="EmpSepId"]').val();
                                                refreshModalData(empSepId);  // Refresh the modal data after submission
                                            } else if (buttonId === 'final-submit-btn-acct') {
                                                // If the Final Submit button was clicked, reload the page
                                                setTimeout(function() {
                                                    location.reload();  // Reload the page after a short delay to match the toast timeout
                                                }, 3000); // Delay before reload to match the toast timeout
                                    }

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                $('#loader').hide();

                                }
                            })
                            .catch(error => {
                                // Handle errors from the fetch request itself
                                toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
                                $('#loader').hide();

                            });
                            }

                        // Event listener for "Save as Draft" button
                        saveDraftButton.addEventListener('click', function (event) {
                            handleFormSubmission('save-draft-btn-acct', event); // Pass 'save-draft-btn' as the button ID
                        });

                        // Event listener for "Final Submit" button
                        submitButton.addEventListener('click', function (event) {
                            handleFormSubmission('final-submit-btn-acct', event); // Pass 'final-submit-btn' as the button ID
                        });


         

                    });
                     // Function to refresh the modal content
                        function refreshModalData(empSepId) {
                         $.ajax({
                                url: '/get-noc-data-acct/' + empSepId,  // Endpoint to get the NOC data
                                method: 'GET',
                                success: function (response) {
                                    if (response.success) {
                                        var nocData = response.data; // Data returned from backend

                                        // Populate the modal fields with fetched data
                                        // Set Employee Info
                                        $('.emp-name').text(nocData.emp_name);
                                        $('.designation').text(nocData.designation);
                                        $('.emp-code').text(nocData.emp_code);
                                        $('.department').text(nocData.department);

                                        // Set NOC form values for the checkboxes and recovery amounts
                                        populateAccountFormFields(nocData);

                                        // Show the modal
                                        $('#clearnsdetailsAcct').modal('show');
                                    }
                                    // } else {
                                    //     alert('No data found for this employee.');
                                    // }
                                },
                                // error: function () {
                                //     alert('Error fetching NOC data.');
                                // }
                            });
                                   // Function to populate the form fields in the account section
            function populateAccountFormFields(nocData) {
                console.log(nocData);
                // Initialize variables for totals
                let acctEarnings = 0;
                let ITEarnings = 0;
                let LOGEarnings = 0;

                let acctDeductions = 0;
            
                // 1. Expenses Claim Pending (AccECP)
                if (nocData.AccECP === 'Y') {
                    $('input[name="AccECP"][value="Y"]').prop('checked', true);
                } else if (nocData.AccECP === 'N') {
                    $('input[name="AccECP"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccECP"][value=""]').prop('checked', true);
                }
                $('input[name="AccECP_Amt"]').val(nocData.AccECP_Amt);
                $('input[name="AccECP_Amt2"]').val(nocData.AccECP_Amt2);
                acctEarnings += parseFloat(nocData.AccECP_Amt || 0);
                acctDeductions += parseFloat(nocData.AccECP_Amt2 || 0);
                $('input[name="AccECP_Remark"]').val(nocData.AccECP_Remark);

                // 2. IPS Account (AccIPS)
                if (nocData.AccIPS === 'Y') {
                    $('input[name="AccIPS"][value="Y"]').prop('checked', true);
                } else if (nocData.AccIPS === 'N') {
                    $('input[name="AccIPS"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccIPS"][value=""]').prop('checked', true);
                }
                $('input[name="AccIPS_Amt"]').val(nocData.AccIPS_Amt);
                $('input[name="AccIPS_Amt2"]').val(nocData.AccIPS_Amt2);
                acctEarnings += parseFloat(nocData.AccIPS_Amt || 0);
                acctDeductions += parseFloat(nocData.AccIPS_Amt2 || 0);
                $('input[name="AccIPS_Remark"]').val(nocData.AccIPS_Remark);

                // 3. AMS (AccAMS)
                if (nocData.AccAMS === 'Y') {
                    $('input[name="AccAMS"][value="Y"]').prop('checked', true);
                } else if (nocData.AccAMS === 'N') {
                    $('input[name="AccAMS"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccAMS"][value=""]').prop('checked', true);
                }
                $('input[name="AccAMS_Amt"]').val(nocData.AccAMS_Amt);
                $('input[name="AccAMS_Amt2"]').val(nocData.AccAMS_Amt2);
                acctEarnings += parseFloat(nocData.AccAMS_Amt || 0);
                acctDeductions += parseFloat(nocData.AccAMS_Amt2 || 0);
                $('input[name="AccAMS_Remark"]').val(nocData.AccAMS_Remark);

                // 4. SAR (AccSAR)
                if (nocData.AccSAR === 'Y') {
                    $('input[name="AccSAR"][value="Y"]').prop('checked', true);
                } else if (nocData.AccSAR === 'N') {
                    $('input[name="AccSAR"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccSAR"][value=""]').prop('checked', true);
                }
                $('input[name="AccSAR_Amt"]').val(nocData.AccSAR_Amt);
                $('input[name="AccSAR_Amt2"]').val(nocData.AccSAR_Amt2);
                acctEarnings += parseFloat(nocData.AccSAR_Amt || 0);
                acctDeductions += parseFloat(nocData.AccSAR_Amt2 || 0);
                $('input[name="AccSAR_Remark"]').val(nocData.AccSAR_Remark);

                // 5. WGR (AccWGR)
                if (nocData.AccWGR === 'Y') {
                    $('input[name="AccWGR"][value="Y"]').prop('checked', true);
                } else if (nocData.AccWGR === 'N') {
                    $('input[name="AccWGR"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccWGR"][value=""]').prop('checked', true);
                }
                $('input[name="AccWGR_Amt"]').val(nocData.AccWGR_Amt);
                $('input[name="AccWGR_Amt2"]').val(nocData.AccWGR_Amt2);
                acctEarnings += parseFloat(nocData.AccWGR_Amt || 0);
                acctDeductions += parseFloat(nocData.AccWGR_Amt2 || 0);
                $('input[name="AccWGR_Remark"]').val(nocData.AccWGR_Remark);

                // 6. SB (AccSB)
                if (nocData.AccSB === 'Y') {
                    $('input[name="AccSB"][value="Y"]').prop('checked', true);
                } else if (nocData.AccSB === 'N') {
                    $('input[name="AccSB"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccSB"][value=""]').prop('checked', true);
                }
                $('input[name="AccSB_Amt"]').val(nocData.AccSB_Amt);
                $('input[name="AccSB_Amt2"]').val(nocData.AccSB_Amt2);
                acctEarnings += parseFloat(nocData.AccSB_Amt || 0);
                acctDeductions += parseFloat(nocData.AccSB_Amt2 || 0);
                $('input[name="AccSB_Remark"]').val(nocData.AccSB_Remark);

                // 7. TDS Adjustment (AccTDSA)
                if (nocData.AccTDSA === 'Y') {
                    $('input[name="AccTDSA"][value="Y"]').prop('checked', true);
                } else if (nocData.AccTDSA === 'N') {
                    $('input[name="AccTDSA"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccTDSA"][value=""]').prop('checked', true);
                }
                $('input[name="AccTDSA_Amt"]').val(nocData.AccTDSA_Amt);
                $('input[name="AccTDSA_Amt2"]').val(nocData.AccTDSA_Amt2);
                acctEarnings += parseFloat(nocData.AccTDSA_Amt || 0);
                acctDeductions += parseFloat(nocData.AccTDSA_Amt2 || 0);
                $('input[name="AccTDSA_Remark"]').val(nocData.AccTDSA_Remark);

                // 8. Recyclable Material (AccRecy)
                if (nocData.AccRecy === 'Y') {
                    $('input[name="AccRecy"][value="Y"]').prop('checked', true);
                } else if (nocData.AccRecy === 'N') {
                    $('input[name="AccRecy"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccRecy"][value=""]').prop('checked', true);
                }
                            $('input[name="AccRecy_Amt"]').val(nocData.AccRecy_Amt);
                            $('input[name="AccRecy_Amt2"]').val(nocData.AccRecy_Amt2);
                            acctEarnings += parseFloat(nocData.AccRecy_Amt || 0);
                            acctDeductions += parseFloat(nocData.AccRecy_Amt2 || 0);

                $('input[name="AccRecy_Remark"]').val(nocData.AccRecy_Remark);

                // 9. Any remarks in Account
                $('input[name="general_remarks"]').val(nocData.general_remarks);

                // 10. Additional Remarks for Account (if any)
                $('input[name="acct_remark"]').val(nocData.AccOth_Remark);
                console.log(nocData.Acc_NOC);
                if (nocData.Acc_NOC === 'Y') {
                                    // Disable all form fields if the status is 'Y'
                                    //$('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                // Hide the "Save as Draft" and "Final Submit" buttons
                                $('.modal-footer #save-draft-btn-log').hide();
                                    $('.modal-footer #final-submit-btn-log').hide();
                                    $('.modal-footer #save-draft-btn-it').hide();
                                    $('.modal-footer #final-submit-btn-it').hide();
                                    $('.modal-footer #save-draft-btn-acct').hide();
                                    $('.modal-footer #final-submit-btn-acct').hide();
                                }
                // Function to recalculate totals
                function recalculateTotals() {
                    // Fetch updated values from input fields (use || 0 to handle empty values)
                    let AccRecy_Amt = parseFloat($('input[name="AccRecy_Amt"]').val() || 0); // Deduct
                    let AccRecy_Amt2 = parseFloat($('input[name="AccRecy_Amt2"]').val() || 0); // Earning

                    let AccECP_Amt = parseFloat($('input[name="AccECP_Amt"]').val() || 0); // Deduct
                    let AccECP_Amt2 = parseFloat($('input[name="AccECP_Amt2"]').val() || 0); // Earning

                    let AccIPS_Amt = parseFloat($('input[name="AccIPS_Amt"]').val() || 0); // Deduct
                    let AccIPS_Amt2 = parseFloat($('input[name="AccIPS_Amt2"]').val() || 0); // Earning

                    let AccAMS_Amt = parseFloat($('input[name="AccAMS_Amt"]').val() || 0); // Deduct
                    let AccAMS_Amt2 = parseFloat($('input[name="AccAMS_Amt2"]').val() || 0); // Earning

                    let AccSAR_Amt = parseFloat($('input[name="AccSAR_Amt"]').val() || 0); // Deduct
                    let AccSAR_Amt2 = parseFloat($('input[name="AccSAR_Amt2"]').val() || 0); // Earning

                    let AccWGR_Amt = parseFloat($('input[name="AccWGR_Amt"]').val() || 0); // Deduct
                    let AccWGR_Amt2 = parseFloat($('input[name="AccWGR_Amt2"]').val() || 0); // Earning

                    let AccSB_Amt = parseFloat($('input[name="AccSB_Amt"]').val() || 0); // Deduct
                    let AccSB_Amt2 = parseFloat($('input[name="AccSB_Amt2"]').val() || 0); // Earning

                    let AccTDSA_Amt = parseFloat($('input[name="AccTDSA_Amt"]').val() || 0); // Deduct
                    let AccTDSA_Amt2 = parseFloat($('input[name="AccTDSA_Amt2"]').val() || 0); // Earning

                    // Calculate totals for Deduct and Earning separately
                    let totalDeduct = AccRecy_Amt + AccECP_Amt + AccIPS_Amt + AccAMS_Amt + AccSAR_Amt + AccWGR_Amt + AccSB_Amt + AccTDSA_Amt;
                    let totalEarning = AccRecy_Amt2 + AccECP_Amt2 + AccIPS_Amt2 + AccAMS_Amt2 + AccSAR_Amt2 + AccWGR_Amt2 + AccSB_Amt2 + AccTDSA_Amt2;

                    // Update the fields with the calculated totals
                    $('#account-earnings').val(totalDeduct.toFixed(2));  // Format to 2 decimal places
                    $('#account-deductions').val(totalEarning.toFixed(2));  // Format to 2 decimal places

                }

                // Attach event listeners to each input field for real-time calculation
                $('input[name="AccRecy_Amt"], input[name="AccRecy_Amt2"], input[name="AccECP_Amt"], input[name="AccECP_Amt2"], input[name="AccIPS_Amt"], input[name="AccIPS_Amt2"], input[name="AccAMS_Amt"], input[name="AccAMS_Amt2"], input[name="AccSAR_Amt"], input[name="AccSAR_Amt2"], input[name="AccWGR_Amt"], input[name="AccWGR_Amt2"], input[name="AccSB_Amt"], input[name="AccSB_Amt2"], input[name="AccTDSA_Amt"], input[name="AccTDSA_Amt2"]').on('input', function() {
                    recalculateTotals();  // Recalculate and update totals on input change
                });

                // Initial calculation when the page loads
                $(document).ready(function() {
                    recalculateTotals();  // Calculate and display the initial totals
                });

                    // Function to update total earnings and deductions
                    function updateTotals() {
                                        // Retrieve the input elements
                    var itEarningsInput = document.getElementById('it-earnings');
                    var logisticsEarningsInput = document.getElementById('logistics-earnings');
                    var accountEarningsInput = document.getElementById('account-earnings');
                    var accountDeductionsInput = document.getElementById('account-deductions');
                    var logisticsDeductionsInput = document.getElementById('logistics-deductions');
                    var itDeductionsInput = document.getElementById('it-deductions');
                    var hrEarningInput = document.getElementById('hr-earnings');
                    var hrDeductionsInput = document.getElementById('hr-deductions');
                    
                    // Retrieve and parse the values as floats, defaulting to 0 if not a valid number
                    var itEarningsValue = parseFloat(itEarningsInput.value) || 0;
                    var logisticsEarningsValue = parseFloat(logisticsEarningsInput.value) || 0;
                    var accountEarningsValue = parseFloat(accountEarningsInput.value) || 0;
                    var accountDeductionsValue = parseFloat(accountDeductionsInput.value) || 0;
                    var logisticsDeductionsValue = parseFloat(logisticsDeductionsInput.value) || 0;
                    var itDeductionsValue = parseFloat(itDeductionsInput.value) || 0;
                    var hrEarningInput = parseFloat(hrEarningInput.value) || 0;
                    var hrDeductionsInput =  parseFloat(hrDeductionsInput.value) || 0;
                    console.log(hrDeductionsInput);

                    // Calculate total earnings and total deductions
                    var totalEarnings = itDeductionsValue + logisticsDeductionsValue + accountEarningsValue + hrEarningInput;
                    var totalDeductions = accountDeductionsValue + logisticsEarningsValue + itEarningsValue + hrDeductionsInput;



                        // Update the DOM with the calculated totals
                        $('#total-earnings').text(totalEarnings.toFixed(0));  // Show total earnings rounded to nearest integer
                        $('#total-deductions').text(totalDeductions.toFixed(0));  // Show total deductions rounded to nearest integer
                    }

                    // Attach event listeners to each input field to trigger recalculation
                    $('input[name="AccRecy_Amt"], input[name="AccRecy_Amt2"], input[name="AccECP_Amt"], input[name="AccECP_Amt2"], input[name="AccIPS_Amt"], input[name="AccIPS_Amt2"], input[name="AccAMS_Amt"], input[name="AccAMS_Amt2"], input[name="AccSAR_Amt"], input[name="AccSAR_Amt2"], input[name="AccWGR_Amt"], input[name="AccWGR_Amt2"], input[name="AccSB_Amt"], input[name="AccSB_Amt2"], input[name="AccTDSA_Amt"], input[name="AccTDSA_Amt2"]').on('input', function() {
                        updateTotals();  // Recalculate and update totals on input change
                    });

                    // Initial calculation when the page loads
                    document.getElementById('acct-tab').addEventListener('click', function() {
                        updateTotals();  // Calculate and display the initial totals
                    });

                
                
                
                }
                }
                            
            

    

                    $('#clearnsdetailsAcct').on('show.bs.modal', function (event) {
                    // Function to calculate and update total deductions
                    function updateTotalDeductions() {
                        let totalDeductions = 0;  // Initialize total deductions

                        // Sum all deduction fields
                        totalDeductions += sumByName('AccECP_Amt');
                        totalDeductions += sumByName('AccIPS_Amt');
                        totalDeductions += sumByName('AccAMS_Amt');
                        totalDeductions += sumByName('AccSAR_Amt');
                        totalDeductions += sumByName('AccWGR_Amt');
                        totalDeductions += sumByName('AccSB_Amt');
                        totalDeductions += sumByName('AccTDSA_Amt');
                        totalDeductions += sumByName('AccRecy_Amt');
                        console.log(totalDeductions);

                        // Store the total deductions in a data attribute
                        $('#clearnsdetailsAcct').data('total-earnings', totalDeductions.toFixed(2));
                        
                        // Update totals (pass only total deductions for now)
                        updateTotals();

                        // Update the total deductions field
                        $('#account-earnings').val(totalDeductions.toFixed(2));

                        // Log to debug
                        console.log("Updated Total earnings:", totalDeductions.toFixed(2));
                    }

                    // Function to sum the values based on the field name
                    function sumByName(fieldName) {
                        let total = 0;

                        // Sum all values of input fields with the given name
                        $("input[name='" + fieldName + "']").each(function () {
                            total += parseFloat($(this).val()) || 0;  // Use 0 if value is empty
                        });

                        return total;
                    }

                    // Trigger the update when the modal is shown
                    $('#clearnsdetailsAcct').on('show.bs.modal', function (event) {
                        // Update total deductions when modal shows
                        updateTotalDeductions();
                    });

                    // If you want to update the deductions when any input changes:
                    $(document).on('input', "input[name^='Acc'][name$='_Amt']", function () {
                        updateTotalDeductions();  // Update the total deductions when deduction fields are modified
                    });

                    // Initial calculation when the page loads
                    document.getElementById('acct-tab').addEventListener('click', function () {
                        updateTotals();  // Calculate and display the initial totals
                    });

                    // Function to calculate and update total earnings
                    function updateEarnings() {
                        let totalEarnings = 0;  // Initialize total earnings

                        // Sum all earning fields (fields ending with '_Amt2' in this case)
                        $("input[name$='_Amt2']").each(function () {
                            totalEarnings += parseFloat($(this).val()) || 0;  // Use 0 if value is empty
                        });

                        // Store the total earnings in a data attribute
                        $('#clearnsdetailsAcct').data('total-deductions', totalEarnings.toFixed(2));

                        // Update totals (pass only total earnings for now)
                        updateTotals();

                        // Update the total earnings field
                        $('#account-deductions').val(totalEarnings.toFixed(2));

                        // Log to debug
                        console.log("Updated Total deduction:", totalEarnings.toFixed(2));
                    }

                    // Trigger the update when the modal is shown
                    $('#clearnsdetailsAcct').on('show.bs.modal', function (event) {
                        updateEarnings();  // Initialize total earnings
                    });

                    // If you want to update the earnings when any input changes:
                    $(document).on('input', "input[name$='_Amt2']", function () {
                        updateEarnings();  // Update the total earnings when earning fields are modified
                    });
    // Function to update total earnings and deductions
                    function updateTotals() {
                                        // Retrieve the input elements
                    var itEarningsInput = document.getElementById('it-earnings');
                    var logisticsEarningsInput = document.getElementById('logistics-earnings');
                    var accountEarningsInput = document.getElementById('account-earnings');
                    var accountDeductionsInput = document.getElementById('account-deductions');
                    var logisticsDeductionsInput = document.getElementById('logistics-deductions');
                    var itDeductionsInput = document.getElementById('it-deductions');
                    var hrEarningInput = document.getElementById('hr-earnings');
                    var hrDeductionsInput = document.getElementById('hr-deductions');
                    
                    // Retrieve and parse the values as floats, defaulting to 0 if not a valid number
                    var itEarningsValue = parseFloat(itEarningsInput.value) || 0;
                    var logisticsEarningsValue = parseFloat(logisticsEarningsInput.value) || 0;
                    var accountEarningsValue = parseFloat(accountEarningsInput.value) || 0;
                    var accountDeductionsValue = parseFloat(accountDeductionsInput.value) || 0;
                    var logisticsDeductionsValue = parseFloat(logisticsDeductionsInput.value) || 0;
                    var itDeductionsValue = parseFloat(itDeductionsInput.value) || 0;
                    var hrEarningInput = parseFloat(hrEarningInput.value) || 0;
                    var hrDeductionsInput =  parseFloat(hrDeductionsInput.value) || 0;
                    console.log(hrDeductionsInput);

                    // Calculate total earnings and total deductions
                    var totalEarnings = itDeductionsValue + logisticsDeductionsValue + accountEarningsValue + hrEarningInput;
                    var totalDeductions = accountDeductionsValue + logisticsEarningsValue + itEarningsValue + hrDeductionsInput;



                        // Update the DOM with the calculated totals
                        $('#total-earnings').text(totalEarnings.toFixed(0));  // Show total earnings rounded to nearest integer
                        $('#total-deductions').text(totalDeductions.toFixed(0));  // Show total deductions rounded to nearest integer
                    }

                    // Attach event listeners to each input field to trigger recalculation
                    $('input[name="AccRecy_Amt"], input[name="AccRecy_Amt2"], input[name="AccECP_Amt"], input[name="AccECP_Amt2"], input[name="AccIPS_Amt"], input[name="AccIPS_Amt2"], input[name="AccAMS_Amt"], input[name="AccAMS_Amt2"], input[name="AccSAR_Amt"], input[name="AccSAR_Amt2"], input[name="AccWGR_Amt"], input[name="AccWGR_Amt2"], input[name="AccSB_Amt"], input[name="AccSB_Amt2"], input[name="AccTDSA_Amt"], input[name="AccTDSA_Amt2"]').on('input', function() {
                        updateTotals();  // Recalculate and update totals on input change
                    });

                    // Initial calculation when the page loads
                    document.getElementById('acct-tab').addEventListener('click', function() {
                        updateTotals();  // Calculate and display the initial totals
                    });

                            
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var empName = button.data('emp-name');
                    var designation = button.data('designation');
                    var empCode = button.data('emp-code');
                    var department = button.data('department');
                    var empSepId = button.data('emp-sepid');
                    var employeeidacct = button.data('employee-id');


                    // Update the modal's content with employee data
                    var modal = $(this);
                    modal.find('.emp-name').text(empName);
                    modal.find('.designation').text(designation);
                    modal.find('.emp-code').text(empCode);
                    modal.find('.department').text(department);


                    // Set the EmpSepId in a hidden input field to send with the form
                    modal.find('input[name="EmpSepId"]').val(empSepId);
                    modal.find('input[name="EmployeeID"]').val(employeeidacct);

                    $('#logistics-tab').trigger('click');
                    $('#it-tab').trigger('click');


                    $.ajax({
                                url: '/get-noc-data-acct/' + empSepId,  // Endpoint to get the NOC data
                                method: 'GET',
                                success: function (response) {
                                    if (response.success) {
                                        var nocData = response.data; // Data returned from backend

                                        // Populate the modal fields with fetched data
                                        // Set Employee Info
                                        $('.emp-name').text(nocData.emp_name);
                                        $('.designation').text(nocData.designation);
                                        $('.emp-code').text(nocData.emp_code);
                                        $('.department').text(nocData.department);

                                        // Set NOC form values for the checkboxes and recovery amounts
                                        populateAccountFormFields(nocData);

                                        // Show the modal
                                        $('#clearnsdetailsAcct').modal('show');
                                    }
                                    // } else {
                                    //     alert('No data found for this employee.');
                                    // }
                                },
                                // error: function () {
                                //     alert('Error fetching NOC data.');
                                // }
                            });
                    
                 // Function to populate the form fields in the account section
            function populateAccountFormFields(nocData) {
                console.log(nocData);
                // Initialize variables for totals
                let acctEarnings = 0;
                let ITEarnings = 0;
                let LOGEarnings = 0;

                let acctDeductions = 0;
            
                // 1. Expenses Claim Pending (AccECP)
                if (nocData.AccECP === 'Y') {
                    $('input[name="AccECP"][value="Y"]').prop('checked', true);
                } else if (nocData.AccECP === 'N') {
                    $('input[name="AccECP"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccECP"][value=""]').prop('checked', true);
                }
                $('input[name="AccECP_Amt"]').val(nocData.AccECP_Amt);
                $('input[name="AccECP_Amt2"]').val(nocData.AccECP_Amt2);
                acctEarnings += parseFloat(nocData.AccECP_Amt || 0);
                acctDeductions += parseFloat(nocData.AccECP_Amt2 || 0);
                $('input[name="AccECP_Remark"]').val(nocData.AccECP_Remark);

                // 2. IPS Account (AccIPS)
                if (nocData.AccIPS === 'Y') {
                    $('input[name="AccIPS"][value="Y"]').prop('checked', true);
                } else if (nocData.AccIPS === 'N') {
                    $('input[name="AccIPS"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccIPS"][value=""]').prop('checked', true);
                }
                $('input[name="AccIPS_Amt"]').val(nocData.AccIPS_Amt);
                $('input[name="AccIPS_Amt2"]').val(nocData.AccIPS_Amt2);
                acctEarnings += parseFloat(nocData.AccIPS_Amt || 0);
                acctDeductions += parseFloat(nocData.AccIPS_Amt2 || 0);
                $('input[name="AccIPS_Remark"]').val(nocData.AccIPS_Remark);

                // 3. AMS (AccAMS)
                if (nocData.AccAMS === 'Y') {
                    $('input[name="AccAMS"][value="Y"]').prop('checked', true);
                } else if (nocData.AccAMS === 'N') {
                    $('input[name="AccAMS"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccAMS"][value=""]').prop('checked', true);
                }
                $('input[name="AccAMS_Amt"]').val(nocData.AccAMS_Amt);
                $('input[name="AccAMS_Amt2"]').val(nocData.AccAMS_Amt2);
                acctEarnings += parseFloat(nocData.AccAMS_Amt || 0);
                acctDeductions += parseFloat(nocData.AccAMS_Amt2 || 0);
                $('input[name="AccAMS_Remark"]').val(nocData.AccAMS_Remark);

                // 4. SAR (AccSAR)
                if (nocData.AccSAR === 'Y') {
                    $('input[name="AccSAR"][value="Y"]').prop('checked', true);
                } else if (nocData.AccSAR === 'N') {
                    $('input[name="AccSAR"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccSAR"][value=""]').prop('checked', true);
                }
                $('input[name="AccSAR_Amt"]').val(nocData.AccSAR_Amt);
                $('input[name="AccSAR_Amt2"]').val(nocData.AccSAR_Amt2);
                acctEarnings += parseFloat(nocData.AccSAR_Amt || 0);
                acctDeductions += parseFloat(nocData.AccSAR_Amt2 || 0);
                $('input[name="AccSAR_Remark"]').val(nocData.AccSAR_Remark);

                // 5. WGR (AccWGR)
                if (nocData.AccWGR === 'Y') {
                    $('input[name="AccWGR"][value="Y"]').prop('checked', true);
                } else if (nocData.AccWGR === 'N') {
                    $('input[name="AccWGR"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccWGR"][value=""]').prop('checked', true);
                }
                $('input[name="AccWGR_Amt"]').val(nocData.AccWGR_Amt);
                $('input[name="AccWGR_Amt2"]').val(nocData.AccWGR_Amt2);
                acctEarnings += parseFloat(nocData.AccWGR_Amt || 0);
                acctDeductions += parseFloat(nocData.AccWGR_Amt2 || 0);
                $('input[name="AccWGR_Remark"]').val(nocData.AccWGR_Remark);

                // 6. SB (AccSB)
                if (nocData.AccSB === 'Y') {
                    $('input[name="AccSB"][value="Y"]').prop('checked', true);
                } else if (nocData.AccSB === 'N') {
                    $('input[name="AccSB"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccSB"][value=""]').prop('checked', true);
                }
                $('input[name="AccSB_Amt"]').val(nocData.AccSB_Amt);
                $('input[name="AccSB_Amt2"]').val(nocData.AccSB_Amt2);
                acctEarnings += parseFloat(nocData.AccSB_Amt || 0);
                acctDeductions += parseFloat(nocData.AccSB_Amt2 || 0);
                $('input[name="AccSB_Remark"]').val(nocData.AccSB_Remark);

                // 7. TDS Adjustment (AccTDSA)
                if (nocData.AccTDSA === 'Y') {
                    $('input[name="AccTDSA"][value="Y"]').prop('checked', true);
                } else if (nocData.AccTDSA === 'N') {
                    $('input[name="AccTDSA"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccTDSA"][value=""]').prop('checked', true);
                }
                $('input[name="AccTDSA_Amt"]').val(nocData.AccTDSA_Amt);
                $('input[name="AccTDSA_Amt2"]').val(nocData.AccTDSA_Amt2);
                acctEarnings += parseFloat(nocData.AccTDSA_Amt || 0);
                acctDeductions += parseFloat(nocData.AccTDSA_Amt2 || 0);
                $('input[name="AccTDSA_Remark"]').val(nocData.AccTDSA_Remark);

                // 8. Recyclable Material (AccRecy)
                if (nocData.AccRecy === 'Y') {
                    $('input[name="AccRecy"][value="Y"]').prop('checked', true);
                } else if (nocData.AccRecy === 'N') {
                    $('input[name="AccRecy"][value="N"]').prop('checked', true);
                } else {
                    $('input[name="AccRecy"][value=""]').prop('checked', true);
                }
                            $('input[name="AccRecy_Amt"]').val(nocData.AccRecy_Amt);
                            $('input[name="AccRecy_Amt2"]').val(nocData.AccRecy_Amt2);
                            acctEarnings += parseFloat(nocData.AccRecy_Amt || 0);
                            acctDeductions += parseFloat(nocData.AccRecy_Amt2 || 0);

                $('input[name="AccRecy_Remark"]').val(nocData.AccRecy_Remark);

                // 9. Any remarks in Account
                $('input[name="general_remarks"]').val(nocData.general_remarks);

                // 10. Additional Remarks for Account (if any)
                $('input[name="acct_remark"]').val(nocData.AccOth_Remark);
                console.log(nocData.Acc_NOC);
                if (nocData.Acc_NOC === 'Y') {
                                    // Disable all form fields if the status is 'Y'
                                    //$('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                // Hide the "Save as Draft" and "Final Submit" buttons
                                $('.modal-footer #save-draft-btn-log').hide();
                                    $('.modal-footer #final-submit-btn-log').hide();
                                    $('.modal-footer #save-draft-btn-it').hide();
                                    $('.modal-footer #final-submit-btn-it').hide();
                                    $('.modal-footer #save-draft-btn-acct').hide();
                                    $('.modal-footer #final-submit-btn-acct').hide();
                                }
                // Function to recalculate totals
                function recalculateTotals() {
                    // Fetch updated values from input fields (use || 0 to handle empty values)
                    let AccRecy_Amt = parseFloat($('input[name="AccRecy_Amt"]').val() || 0); // Deduct
                    let AccRecy_Amt2 = parseFloat($('input[name="AccRecy_Amt2"]').val() || 0); // Earning

                    let AccECP_Amt = parseFloat($('input[name="AccECP_Amt"]').val() || 0); // Deduct
                    let AccECP_Amt2 = parseFloat($('input[name="AccECP_Amt2"]').val() || 0); // Earning

                    let AccIPS_Amt = parseFloat($('input[name="AccIPS_Amt"]').val() || 0); // Deduct
                    let AccIPS_Amt2 = parseFloat($('input[name="AccIPS_Amt2"]').val() || 0); // Earning

                    let AccAMS_Amt = parseFloat($('input[name="AccAMS_Amt"]').val() || 0); // Deduct
                    let AccAMS_Amt2 = parseFloat($('input[name="AccAMS_Amt2"]').val() || 0); // Earning

                    let AccSAR_Amt = parseFloat($('input[name="AccSAR_Amt"]').val() || 0); // Deduct
                    let AccSAR_Amt2 = parseFloat($('input[name="AccSAR_Amt2"]').val() || 0); // Earning

                    let AccWGR_Amt = parseFloat($('input[name="AccWGR_Amt"]').val() || 0); // Deduct
                    let AccWGR_Amt2 = parseFloat($('input[name="AccWGR_Amt2"]').val() || 0); // Earning

                    let AccSB_Amt = parseFloat($('input[name="AccSB_Amt"]').val() || 0); // Deduct
                    let AccSB_Amt2 = parseFloat($('input[name="AccSB_Amt2"]').val() || 0); // Earning

                    let AccTDSA_Amt = parseFloat($('input[name="AccTDSA_Amt"]').val() || 0); // Deduct
                    let AccTDSA_Amt2 = parseFloat($('input[name="AccTDSA_Amt2"]').val() || 0); // Earning

                    // Calculate totals for Deduct and Earning separately
                    let totalDeduct = AccRecy_Amt + AccECP_Amt + AccIPS_Amt + AccAMS_Amt + AccSAR_Amt + AccWGR_Amt + AccSB_Amt + AccTDSA_Amt;
                    let totalEarning = AccRecy_Amt2 + AccECP_Amt2 + AccIPS_Amt2 + AccAMS_Amt2 + AccSAR_Amt2 + AccWGR_Amt2 + AccSB_Amt2 + AccTDSA_Amt2;

                    // Update the fields with the calculated totals
                    $('#account-earnings').val(totalDeduct.toFixed(2));  // Format to 2 decimal places
                    $('#account-deductions').val(totalEarning.toFixed(2));  // Format to 2 decimal places

                }

                // Attach event listeners to each input field for real-time calculation
                $('input[name="AccRecy_Amt"], input[name="AccRecy_Amt2"], input[name="AccECP_Amt"], input[name="AccECP_Amt2"], input[name="AccIPS_Amt"], input[name="AccIPS_Amt2"], input[name="AccAMS_Amt"], input[name="AccAMS_Amt2"], input[name="AccSAR_Amt"], input[name="AccSAR_Amt2"], input[name="AccWGR_Amt"], input[name="AccWGR_Amt2"], input[name="AccSB_Amt"], input[name="AccSB_Amt2"], input[name="AccTDSA_Amt"], input[name="AccTDSA_Amt2"]').on('input', function() {
                    recalculateTotals();  // Recalculate and update totals on input change
                });

                // Initial calculation when the page loads
                $(document).ready(function() {
                    recalculateTotals();  // Calculate and display the initial totals
                });

                    // Function to update total earnings and deductions
                    function updateTotals() {
                                        // Retrieve the input elements
                    var itEarningsInput = document.getElementById('it-earnings');
                    var logisticsEarningsInput = document.getElementById('logistics-earnings');
                    var accountEarningsInput = document.getElementById('account-earnings');
                    var accountDeductionsInput = document.getElementById('account-deductions');
                    var logisticsDeductionsInput = document.getElementById('logistics-deductions');
                    var itDeductionsInput = document.getElementById('it-deductions');
                    var hrEarningInput = document.getElementById('hr-earnings');
                    var hrDeductionsInput = document.getElementById('hr-deductions');
                    
                    // Retrieve and parse the values as floats, defaulting to 0 if not a valid number
                    var itEarningsValue = parseFloat(itEarningsInput.value) || 0;
                    var logisticsEarningsValue = parseFloat(logisticsEarningsInput.value) || 0;
                    var accountEarningsValue = parseFloat(accountEarningsInput.value) || 0;
                    var accountDeductionsValue = parseFloat(accountDeductionsInput.value) || 0;
                    var logisticsDeductionsValue = parseFloat(logisticsDeductionsInput.value) || 0;
                    var itDeductionsValue = parseFloat(itDeductionsInput.value) || 0;
                    var hrEarningInput = parseFloat(hrEarningInput.value) || 0;
                    var hrDeductionsInput =  parseFloat(hrDeductionsInput.value) || 0;
                    console.log(hrDeductionsInput);

                    // Calculate total earnings and total deductions
                    var totalEarnings = itDeductionsValue + logisticsDeductionsValue + accountEarningsValue + hrEarningInput;
                    var totalDeductions = accountDeductionsValue + logisticsEarningsValue + itEarningsValue + hrDeductionsInput;



                        // Update the DOM with the calculated totals
                        $('#total-earnings').text(totalEarnings.toFixed(0));  // Show total earnings rounded to nearest integer
                        $('#total-deductions').text(totalDeductions.toFixed(0));  // Show total deductions rounded to nearest integer
                    }

                    // Attach event listeners to each input field to trigger recalculation
                    $('input[name="AccRecy_Amt"], input[name="AccRecy_Amt2"], input[name="AccECP_Amt"], input[name="AccECP_Amt2"], input[name="AccIPS_Amt"], input[name="AccIPS_Amt2"], input[name="AccAMS_Amt"], input[name="AccAMS_Amt2"], input[name="AccSAR_Amt"], input[name="AccSAR_Amt2"], input[name="AccWGR_Amt"], input[name="AccWGR_Amt2"], input[name="AccSB_Amt"], input[name="AccSB_Amt2"], input[name="AccTDSA_Amt"], input[name="AccTDSA_Amt2"]').on('input', function() {
                        updateTotals();  // Recalculate and update totals on input change
                    });

                    // Initial calculation when the page loads
                    document.getElementById('acct-tab').addEventListener('click', function() {
                        updateTotals();  // Calculate and display the initial totals
                    });

                
                
                
                }


                });

                    // acct ends

                //Logistics start
                // // Attach a single event listener to a parent container (in this case, 'parties-container')
                // document.getElementById('parties-container').addEventListener('change', function(event) {
                //     // Check if the clicked element is a checkbox
                //     if (event.target && event.target.type === 'checkbox') {
                //         const checkbox = event.target;
                //         const name = checkbox.name;
                        
                //         // Uncheck all checkboxes in the same group, except the one that was just clicked
                //         document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
                //             if (otherCheckbox !== checkbox) {
                //                 otherCheckbox.checked = false;
                //             }
                //         });
                //     }
                // });
                // document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
                //     checkbox.addEventListener('change', function () {
                //         // Get the name of the group (all checkboxes with the same name)
                //         const name = this.name;
                        
                //         // Uncheck all checkboxes in the group, except the one that was just clicked
                //         document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
                //             if (otherCheckbox !== checkbox) {
                //                 otherCheckbox.checked = false;
                //             }
                //         });
                //     });
                // });
                // // Event delegation for remove buttons
                // document.getElementById('parties-container').addEventListener('click', function(event) {
                //     // Check if the clicked element is a remove button
                //     if (event.target && event.target.classList.contains('remove-party')) {
                //         const partyId = event.target.getAttribute('data-party-id');
                //         const partyElement = document.getElementById(partyId);
                        
                //         // Remove the party section from the DOM
                //         if (partyElement) {
                //             partyElement.remove();
                //         }
                //     }
                // });


                 //Logistics start
                 document.addEventListener("DOMContentLoaded", function () {

    // Event listener for when the logistics tab is clicked
    $('#logistics-tab').on('click', function () {
        // Clear the parties container before populating it again
        const partiesContainer = document.getElementById('parties-container');
        partiesContainer.innerHTML = ''; // Reset the container content
        const saveDraftButton = document.getElementById('save-draft-btn-log');
        const submitButton = document.getElementById('final-submit-btn-log');
    const form = document.getElementById('logisticsnocform');

        // Reset partyIndex and appendedParties set
        let partyIndex = 1;
        let appendedParties = new Set(); // Set to track unique party names

        var empSepId = $('input[name="EmpSepId"]').val();
        var employeeid = $('input[name="EmployeeID"]').val();

        $.ajax({
            url: '/get-noc-data/' + empSepId + '/' + employeeid, // Assuming the endpoint is correct
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var nocData = response.data;

                    // Update the modal with employee info
                    var modal = $(this);
                    modal.find('.emp-name').text(nocData.empName);
                    modal.find('.designation').text(nocData.designation);
                    modal.find('.emp-code').text(nocData.empCode);
                    modal.find('.department').text(nocData.department);
                    modal.find('input[name="EmpSepId"]').val(empSepId);

                    // Populate checkboxes and input fields with the fetched data
                // 1. Handover of Data Documents etc (DDH)
                if (nocData.DDH === 'Y') {
                    $('input[name="DDH[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.DDH === 'N') {
                    $('input[name="DDH[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="DDH[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="DDH_Amt"]').val(nocData.DDH_Amt);
                $('input[name="DDH_Remark"]').val(nocData.DDH_Remark);

                // 2. Handover of ID Card (TID)
                if (nocData.TID === 'Y') {
                    $('input[name="TID[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.TID === 'N') {
                    $('input[name="TID[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="TID[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="TID_Amt"]').val(nocData.TID_Amt);
                $('input[name="TID_Remark"]').val(nocData.TID_Remark);

                // 3. Complete pending task (APTC)
                if (nocData.APTC === 'Y') {
                    $('input[name="APTC[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.APTC === 'N') {
                    $('input[name="APTC[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="APTC[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="APTC_Amt"]').val(nocData.APTC_Amt);
                $('input[name="APTC_Remark"]').val(nocData.APTC_Remark);

                // 4. Handover of Health Card (HOAS)
                if (nocData.HOAS === 'Y') {
                    $('input[name="HOAS[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.HOAS === 'N') {
                    $('input[name="HOAS[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="HOAS[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }
                $('input[name="HOAS_Amt"]').val(nocData.HOAS_Amt);
                $('input[name="HOAS_Remark"]').val(nocData.HOAS_Remark);
                $('input[name="otherremark"]').val(nocData.Oth_Remark);

                                       // Assuming the response data looks like this:
            let dealerNames = response.dealerNames; // This will be an array of dealer names
            let partyIndex = 1;

            while (nocData[`Prtis${partyIndex}`] || dealerNames[partyIndex - 1]) {
                // Default party name from nocData
                let partyName = nocData[`Prtis${partyIndex}`] || dealerNames[partyIndex - 1]; // If no nocData, use dealer name

                // Dynamically populate party fields
                const partyHTML = `
                    <div class="clformbox" id="party-${partyIndex}">
                        <div class="formlabel">
                            <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyIndex}" value="${partyName}" placeholder="Enter your party name"><br>
                            <input type="checkbox" name="Parties_${partyIndex}_docdata" value="NA" ${nocData[`Prtis_${partyIndex}`] === 'NA' ? 'checked' : ''}><label>NA</label>
                            <input type="checkbox" name="Parties_${partyIndex}_docdata" value="Yes" ${nocData[`Prtis_${partyIndex}`] === 'Y' ? 'checked' : ''}><label>Yes</label>
                            <input type="checkbox" name="Parties_${partyIndex}_docdata" value="No" ${nocData[`Prtis_${partyIndex}`] === 'N' ? 'checked' : ''}><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="number" name="Parties_${partyIndex}_Amt" value="${nocData[`Prtis_${partyIndex}Amt`] || ''}" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="Parties_${partyIndex}_Remark" value="${nocData[`Prtis_${partyIndex}Remark`] || ''}" placeholder="Enter remarks">
                        </div>
                    </div>
                `;

                partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
                partyIndex++;
                calculateTotalAmount();

            }
  
           
                }
              
               // Event listener for 'acct-tab' click
               document.getElementById('acct-tab').addEventListener('click', function() {
               document.getElementById("logistics-earnings").value = nocData.TotRepAmt;  // Update the current value
               document.getElementById("logistics-earnings").setAttribute("value", nocData.TotRepAmt);  // Update the value attribute


               });
            },
            error: function() {
                alert('Error fetching NOC data.');
            }
        });
    
    });
    const saveDraftButton = document.getElementById('save-draft-btn-log');
        const submitButton = document.getElementById('final-submit-btn-log');
    const form = document.getElementById('logisticsnocform');

    // Event listener for "Save as Draft" button
    saveDraftButton.addEventListener('click', function(event) {
        handleFormSubmission('save-draft-btn-log', event); // Pass 'save-draft-btn' as the button ID
    });

    // Event listener for "Final Submit" button
    submitButton.addEventListener('click', function(event) {
        handleFormSubmission('final-submit-btn-log', event); // Pass 'final-submit-btn' as the button ID
    });

    // Function to calculate total amount specifically within the 'logisticsnocform'
    function calculateTotalAmount() {
        let totalAmount = 0;

        // Target only the amount fields within the 'logisticsnocform' form
        $("#logisticsnocform input[name*='Amt']").each(function() {
            let amount = parseFloat($(this).val()) || 0; // Get the input value and convert to number
            totalAmount += amount;
            $('#total-amount-log').text('Total logistics Amount: ' + totalAmount); // Display total logistics amount in the element with ID 'total-amount-log'

        });

            
    }

            // Initialize total calculation when the page loads
            calculateTotalAmount(); // Run calculation once on page load

            // Event listener for any amount field being changed (real-time)
            $(document).on('input', "input[name*='Amt']", function() {
                calculateTotalAmount(); // Recalculate and update total amount on input change
            });
        });

    // Function to handle form submission (draft or final)
    function handleFormSubmission(buttonId, event) {
    const form = document.getElementById('logisticsnocform');

        event.preventDefault();
        $('#loader').show();
        handleFormSubmission 
        const formData = new FormData(form);
        const formId = form.id;
        formData.append('form_id', formId);
        formData.append('button_id', buttonId);

        // Send form data to the backend
        fetch("{{ route('submit.noc.clearance.logdep') }}", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                $('#loader').hide();

                // Show a success toast notification
                toastr.success(data.message, 'Success', {
                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                });

                // Optionally reload the page after a few seconds
                setTimeout(function () {
                    location.reload();
                }, 3000);
            } else {
                // Show an error toast notification
                toastr.error('Error: ' + data.message, 'Error', {
                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                    "timeOut": 3000
                });
                $('#loader').hide();
            }
        })
        .catch(error => {
            // Handle errors from the fetch request itself
            toastr.error('Error: ' + error.message, 'Error', {
                "positionClass": "toast-top-right",
                "timeOut": 3000
            });
            $('#loader').hide();
        });
    }

            //Logistics end

            //Logistics end


//it clarance start 
document.addEventListener("DOMContentLoaded", function () {

                        const form = document.getElementById('itnocform');
                        const saveDraftButton = document.getElementById('save-draft-btn-it');
                        const submitButton = document.getElementById('final-submit-btn-it');
                        const partiesContainer = document.getElementById('it-parties-container');
                        let partyCount = 1;

                        // Function to handle form submission
                        function handleFormSubmission(buttonId, event) {
                            event.preventDefault();
                            $('#loader').show();

                            const formData = new FormData(form);
                            formData.append('button_id', buttonId); // Add button id to track submission type

                            // Send form data to the Laravel controller using fetch
                            fetch("{{ route('submit.noc.clearance.it') }}", {
                                method: "POST",
                                body: formData,
                            })
                                .then(response => response.json())
                                .then(data => {
                                // Handle the response here (e.g., show success message)
                                if (data.success) {  // Use 'data' instead of 'response'
                                        $('#loader').hide();

                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        location.reload();  // Optionally, reload the page
                                    }, 3000); // Delay before reset and reload to match the toast timeout

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                            $('#loader').hide();

                                }
                            })
                            .catch(error => {
                                // Handle errors from the fetch request itself
                                toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
                            });
                            }

                        // Event listener for "Save as Draft" button
                        saveDraftButton.addEventListener('click', function (event) {

                            handleFormSubmission('save-draft-btn-it', event); // Pass 'save-draft-btn' as the button ID
                        });

                        // Event listener for "Final Submit" button
                        submitButton.addEventListener('click', function (event) {

                            handleFormSubmission('final-submit-btn-it', event); // Pass 'final-submit-btn' as the button ID
                        });

                              /// Function to calculate and update total deductions
                                function calculateTotalAmount() {
                                    let totalAmount = 0;

                                    // Sum all deduction fields
                                    totalAmount += sumByName('sim_recovery_amount');
                                    totalAmount += sumByName('handset_recovery_amount');
                                    totalAmount += sumByName('laptop_recovery_amount');
                                    totalAmount += sumByName('camera_recovery_amount');
                                    totalAmount += sumByName('datacard_recovery_amount');
                                    totalAmount += sumByName('email_recovery_amount');
                                    totalAmount += sumByName('mobile_recovery_amount');

                                    // Update the total deductions field
                                    $('#total-amount-it').text("Total Amount: " + totalAmount.toFixed(2)); // Display total with two decimals
                                }
                                // Function to sum the values based on the field name
                    function sumByName(fieldName) {
                        let total = 0;

                        // Sum all values of input fields with the given name
                        $("input[name='" + fieldName + "']").each(function () {
                            total += parseFloat($(this).val()) || 0;  // Use 0 if value is empty
                        });

                        return total;
                    }



                            // Initialize total calculation when the page loads
                            calculateTotalAmount(); // Run calculation once on page load

                            // Event listener for any amount field being changed (real-time)
                            $(document).on('input', "input[name*='amount']", function() {
                                calculateTotalAmount(); // Recalculate and update total amount on input change
                            });
                            // Trigger the AJAX call when the form (or button) is clicked
                            $('#it-tab').off('click').on('click', function() {

                            
                            var empSepId = $('input[name="EmpSepId"]').val();

                            // Fetch additional data for this EmpSepId using an AJAX request
                            $.ajax({
                                url: '/get-noc-data-it/' + empSepId,  // Endpoint to get the NOC data
                                method: 'GET',
                                success: function (response) {
                                    if (response.success) {
                                        var nocData = response.data; // Data returned from backend

                                        // Populate the modal fields with fetched data

                                        // Set Employee Info
                                        $('.emp-name').text(nocData.emp_name);
                                        $('.designation').text(nocData.designation);
                                        $('.emp-code').text(nocData.emp_code);
                                        $('.department').text(nocData.department);

                                        // Set NOC form values for the checkboxes and recovery amounts
                                        populateFormFields(nocData);

                                        // Show the modal
                                        $('#clearnsdetailsIT').modal('show');
                                    }
                                    // } else {
                                    //     alert('No data found for this employee.');
                                    // }
                                },
                                // error: function () {
                                //     alert('Error fetching NOC data.');
                                // }
                            });

                            function populateFormFields(nocData) {

                                // Initialize total amount variable
                                let totalAmount = 0;

                                // 1. Sim Submitted
                                if (nocData.ItSS === 'Y') {
                                    $('input[name="sim_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItSS === 'N') {
                                    $('input[name="sim_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="sim_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="sim_recovery_amount"]').val(nocData.ItSS_Amt);
                                totalAmount += parseFloat(nocData.ItSS_Amt) || 0;  // Add to total
                                $('input[name="sim_remarks"]').val(nocData.ItSS_Remark);


                                // 2. Company Handset Submitted
                                if (nocData.ItCHS === 'Y') {
                                    $('input[name="handset_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItCHS === 'N') {
                                    $('input[name="handset_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="handset_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="handset_recovery_amount"]').val(nocData.ItCHS_Amt);
                                totalAmount += parseFloat(nocData.ItCHS_Amt) || 0;  // Add to total
                                $('input[name="handset_remarks"]').val(nocData.ItCHS_Remark);

                                // 3. Laptop / Desktop Handover
                                if (nocData.ItLDH === 'Y') {
                                    $('input[name="laptop_handover[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItLDH === 'N') {
                                    $('input[name="laptop_handover[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="laptop_handover[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="laptop_recovery_amount"]').val(nocData.ItLDH_Amt);
                                totalAmount += parseFloat(nocData.ItLDH_Amt) || 0;  // Add to total
                                $('input[name="laptop_remarks"]').val(nocData.ItLDH_Remark);

                                // 4. Camera Submitted
                                if (nocData.ItCS === 'Y') {
                                    $('input[name="camera_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItCS === 'N') {
                                    $('input[name="camera_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="camera_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="camera_recovery_amount"]').val(nocData.ItCS_Amt);
                                totalAmount += parseFloat(nocData.ItCS_Amt) || 0;  // Add to total
                                $('input[name="camera_remarks"]').val(nocData.ItCS_Remark);

                                // 5. Datacard Submitted
                                if (nocData.ItDC === 'Y') {
                                    $('input[name="datacard_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItDC === 'N') {
                                    $('input[name="datacard_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="datacard_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="datacard_recovery_amount"]').val(nocData.ItDC_Amt);
                                totalAmount += parseFloat(nocData.ItDC_Amt) || 0;  // Add to total
                                $('input[name="datacard_remarks"]').val(nocData.ItDC_Remark);

                                // 6. Email Account Blocked
                                if (nocData.ItEAB === 'Y') {
                                    $('input[name="email_blocked[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItEAB === 'N') {
                                    $('input[name="email_blocked[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="email_blocked[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="email_recovery_amount"]').val(nocData.ItEAB_Amt);
                                totalAmount += parseFloat(nocData.ItEAB_Amt) || 0;  // Add to total
                                $('input[name="email_remarks"]').val(nocData.ItEAB_Remark);

                                // 7. Mobile No. Disabled/Transferred
                                if (nocData.ItMND === "Y") {
                                    $('input[name="mobile_disabled[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItMND === "N") {
                                    $('input[name="mobile_disabled[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="mobile_disabled[]"][value="NA"]').prop('checked', true); // Default to NA if no value
                                }
                                $('input[name="mobile_recovery_amount"]').val(nocData.ItMND_Amt);
                                totalAmount += parseFloat(nocData.ItMND_Amt) || 0;  // Add to total
                                $('input[name="mobile_remarks"]').val(nocData.ItMND_Remark);
                                // 8. Any remarks
                                $('input[name="any_remarks"]').val(nocData.ItOth_Remark);

                                // Display the total amount
                                document.getElementById('it-tab').addEventListener('click', function() {
                                         $('#total-amount-it').text('Total Amount: ' + parseFloat(nocData.TotItAmt) || 0);
                                         

                                    });
                                $('#it-earnings').val(nocData.TotItAmt);
                                $('#total-amount-it').text('Total Amount: ' + parseFloat(nocData.TotItAmt) || 0);

                                // Event listener for 'acct-tab' click
                                document.getElementById('acct-tab').addEventListener('click', function() {
                                                            document.getElementById("it-earnings").value = nocData.TotItAmt;  // Update the current value
                                                        document.getElementById("it-earnings").setAttribute("value", nocData.TotItAmt);  // Update the value attribute


                                    });

                                // localStorage.setItem('totalAmountIT', totalAmount);
                                // Handle final submit or draft submit
                                // if (nocData.final_submit_it === 'Y') {
                                //     $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                //     // Hide the "Save as Draft" and "Final Submit" buttons
                                //     $('.modal-footer #save-draft-btn-it').hide();
                                //     $('.modal-footer #final-submit-btn-it').hide();
                                // }
                            }

                        });

                    });
// it clearance end 

//hr clarance start 
document.addEventListener("DOMContentLoaded", function () {
                        const form = document.getElementById('hrnocfrom');
                        const saveDraftButton = document.getElementById('save-draft-btn-it');
                        const submitButton = document.getElementById('final-submit-btn-it');
                        const partiesContainer = document.getElementById('it-parties-container');
                        let partyCount = 1;

                        // Function to handle form submission
                        function handleFormSubmission(buttonId, event) {
                            event.preventDefault();
                            $('#loader').show();

                            const formData = new FormData(form);
                            formData.append('button_id', buttonId); // Add button id to track submission type

                            // Send form data to the Laravel controller using fetch
                            fetch("{{ route('submit.noc.clearance.hr') }}", {
                                method: "POST",
                                body: formData,
                            })
                                .then(response => response.json())
                                .then(data => {
                                // Handle the response here (e.g., show success message)
                                if (data.success) {  // Use 'data' instead of 'response'
                                        $('#loader').hide();

                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        location.reload();  // Optionally, reload the page
                                    }, 3000); // Delay before reset and reload to match the toast timeout

                                } else {
                                    // Show an error toast notification with custom settings
                                    toastr.error('Error: ' + data.message, 'Error', {  // Use 'data' instead of 'response'
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });
                                }
                            })
                            .catch(error => {
                                // Handle errors from the fetch request itself
                                toastr.error('Error: ' + error.message, 'Error', {
                                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                });
                            });
                            }

                      

                            // Trigger the AJAX call when the form (or button) is clicked
            $(document).ready(function() {
                $('#hr-tab').trigger('click');  // This simulates the click event for the tab

                            $('#hr-tab').off('click').on('click', function() {

                            
                            var empSepId = $('input[name="EmpSepId"]').val();
                            var employeeidhr = $('input[name="EmployeeID"]').val();


                            // Fetch additional data for this EmpSepId using an AJAX request
                            $.ajax({
                                url: '/get-noc-data-hr/' + empSepId + '/' + employeeidhr,  // Correct structure
                                method: 'GET',
                                success: function(response) {
                            if (response.success) {
                                var nocData = response.data; // Data returned from backend
                                var ctcData = response.ctc; // Data returned from backend

          
            if (nocData.BEP === 'Y') {
                    $('input[name="block_ess_passward[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.BEP === 'N') {
                    $('input[name="block_ess_passward[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="block_ess_passward[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
                }

            if (nocData.BPP === 'Y') {
                    $('input[name="block_paypac_passward[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.BPP === 'N') {
                    $('input[name="block_paypac_passward[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="block_paypac_passward[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }
            
            if (nocData.BExP === 'Y') {
                    $('input[name="block_expro_passward[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.BExP === 'N') {
                    $('input[name="block_expro_passward[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="block_expro_passward[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }

            // nocData.id_card_submitted.forEach(function(value) {
            //     $('input[name="id_card_submitted[]"][value="' + value + '"]').prop('checked', true);
            // });
            
             if (nocData.AdminIC === 'Y') {
                    $('input[name="id_card_submitted[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.AdminIC === 'N') {
                    $('input[name="id_card_submitted[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="id_card_submitted[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }

            if (nocData.AdminVC === 'Y') {
                    $('input[name="visiting_submitted[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.AdminVC === 'N') {
                    $('input[name="visiting_submitted[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="visiting_submitted[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }
            if (nocData.CV === 'Y') {
                    $('input[name="company_vehicle_return[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
                } else if (nocData.CV === 'N') {
                    $('input[name="company_vehicle_return[]"][value="No"]').prop('checked', true); // Check 'No'
                } else {
                    $('input[name="company_vehicle_return[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
            }
            
            // Filling text inputs
            $('input[name="block_ess_passward_recovery_amount"]').val(nocData.BEP_Amt);
            $('input[name="block_ess_passward_remarks"]').val(nocData.BEP_Remark);
            
            $('input[name="block_paypac_passward_recovery_amount"]').val(nocData.BPP_Amt);
            $('input[name="block_paypac_passward_remarks"]').val(nocData.BPP_Remark);
            
            $('input[name="block_expro_passward_recovery_amount"]').val(nocData.BExP_Amt);
            $('input[name="block_expro_passward_remarks"]').val(nocData.BExP_Remark);
            
            $('input[name="id_card_recovery_amount"]').val(nocData.AdminIC_Amt);
                        $('input[name="id_card_remarks"]').val(nocData.AdminIC_Remark);
            $('input[name="visiting_recovery_amount"]').val(nocData.AdminVC_Amt);
            $('input[name="visiting_remarks"]').val(nocData.AdminVC_Remark);
            
            $('input[name="company_vehcile_recovery_amount"]').val(nocData.CV_Amt);
            $('input[name="company_vehcile_remarks"]').val(nocData.CV_Remark);

            // Filling other fields as well (add all the necessary fields like the worked days, notice period, and earnings)
            $('input[name="worked_days_without_notice"]').val(nocData.WorkDay);
            $('input[name="served_notice_period"]').val(nocData.ServedDay);
            $('input[name="available_el_days"]').val(nocData.TotEL);
            $('input[name="total_worked_days"]').val(nocData.TotWorkDay);
            $('input[name="actual_notice_period"]').val(nocData.NoticeDay);
            $('input[name="recoverable_notice_period"]').val(nocData.RecoveryDay);
            $('input[name="encashable_el_days"]').val(nocData.EnCashEL);
            $('input[name="partially_amount_paid"]').val(nocData.partially_amount_paid);
            // Earnings section
            $('input[name="basic_rate"]').val(ctcData.BAS_Value);
            $('input[name="basic_amount"]').val(nocData.Basic);
            
            $('input[name="hra_rate"]').val(ctcData.HRA_Value);
            $('input[name="hra_amount"]').val(nocData.HRA);
            
            $('input[name="car_allowance_rate"]').val(ctcData.CAR_ALL_Value);
            $('input[name="car_allowance_amount"]').val(nocData.CarAllow);
            
            $('input[name="bonus_rate"]').val(ctcData.Bonus_Month);
            $('input[name="bonus_amount"]').val(nocData.Bonus_Month);
            
            $('input[name="special_allow_rate"]').val(ctcData.SPECIAL_ALL_Value);
            $('input[name="special_allow_amount"]').val(nocData.SA);

            $('input[name="dailyallowance"]').val(nocData.DA);

            $('input[name="monthlygrossrate"]').val(ctcData.GrossSalary_PostAnualComponent_Value);
            $('input[name="monthlygrossamt"]').val(nocData.Gross);


            $('input[name="lta_rate"]').val(Math.round(ctcData.LTA_Value / 12));
            $('input[name="lta_amount"]').val(nocData.LTA);
            
            $('input[name="medical_allow_rate"]').val(Math.round(ctcData.MED_REM_Value / 12));
            $('input[name="medical_allow_amount"]').val(nocData.Mediclaim);
            
            $('input[name="child_edu_allow_rate"]').val(Math.round(ctcData.CHILD_EDU_ALL_Value / 12));
            $('input[name="child_edu_allow_amount"]').val(nocData.CEA);

            $('input[name="leaveencash"]').val(nocData.LE);

            $('input[name="bonusannual"]').val(nocData.Bonus);

            $('input[name="bonusadjst"]').val(nocData.Bonus_Adjustment);

            $('input[name="gratuity"]').val(nocData.Gratuity);

            $('input[name="mediclaim"]').val(nocData.Mediclaim);

            $('input[name="exgretia"]').val(nocData.Exgredia);
            $('input[name="noticepay"]').val(nocData.NoticePay);
            $('input[name="totearn"]').val(nocData.TotEar);


            // Deduction section
            $('input[name="pf_amount"]').val(nocData.PF);
            $('input[name="esic"]').val(nocData.ESIC);
            $('input[name="arrear_esic"]').val(nocData.ARR_ESIC);
            $('input[name="service_bond_recovery"]').val(nocData.RTSB);
            $('input[name="notice_period_recovery"]').val(nocData.NPR);
            $('input[name="notice_period_amount"]').val(nocData.NoticePay);
            $('input[name="voluntary_contribution"]').val(nocData.voluntary_contribution);
            $('input[name="relocation_allowance"]').val(nocData.RA_allow);
            $('input[name="nrs_deduction"]').val(nocData.nrs_deduction);
            if (nocData.TotDeduct === "0.00") {
                                            const totDeduct = 
                    (parseFloat(nocData.PF) || 0) + 
                    (parseFloat(nocData.ESIC) || 0) + 
                    (parseFloat(nocData.ARR_ESIC) || 0) + 
                    (parseFloat(nocData.RTSB) || 0) + 
                    (parseFloat(nocData.NPS_Ded) || 0) + 
                    (parseFloat(nocData.NPR) || 0) + 
                    (parseFloat(nocData.VolC) || 0) + 
                    (parseFloat(nocData.RA_allow) || 0) + 
                    (parseFloat(nocData.AdminIC_Amt) || 0) + 
                    (parseFloat(nocData.AdminVC_Amt) || 0) + 
                    (parseFloat(nocData.CV_Amt) || 0);
                                
                                // Set the calculated total deduction value
                            console.log(totDeduct);

                                $('input[name="total_deduction"]').val(totDeduct.toFixed(2));
                                $('#hr-deductions').val(totDeduct.toFixed(2));

                            } 
                            else {
                                // Set the value from nocData.TotDeduct
                                $('input[name="total_deduction"]').val(nocData.TotDeduct);
                                $('#hr-deductions').val(nocData.TotDeduct);

                            }
                                        $('input[name="hr_remarks"]').val(nocData.HrRemark);
                                $('#hr-earnings').val(nocData.TotEar);

                                // Event listener for 'acct-tab' click
                                
                                document.getElementById('acct-tab').addEventListener('click', function() {

                                                            document.getElementById("hr-earnings").value = nocData.TotEar;  // Update the current value
                                                        document.getElementById("hr-earnings").setAttribute("value", nocData.TotEar);  // Update the value attribute
                                            if (nocData.TotDeduct === "0.00") {
                                                        const totDeduct = 
                                                            (parseFloat(nocData.PF) || 0) + 
                                                            (parseFloat(nocData.ESIC) || 0) + 
                                                            (parseFloat(nocData.ARR_ESIC) || 0) + 
                                                            (parseFloat(nocData.RTSB) || 0) + 
                                                            (parseFloat(nocData.NPS_Ded) || 0) + 
                                                            (parseFloat(nocData.NPR) || 0) + 
                                                            (parseFloat(nocData.VolC) || 0) + 
                                                            (parseFloat(nocData.RA_allow) || 0) + 
                                                            (parseFloat(nocData.AdminIC_Amt) || 0) + 
                                                            (parseFloat(nocData.AdminVC_Amt) || 0) + 
                                                            (parseFloat(nocData.CV_Amt) || 0);

                                                        // Update the input field's value and attribute
                                                        document.getElementById("hr-deductions").value = totDeduct.toFixed(2);
                                                        document.getElementById("hr-deductions").setAttribute("value", totDeduct.toFixed(2));
                                                    } else {
                                                    // Update the input field's value and attribute with TotDeduct
                                                    document.getElementById("hr-deductions").value = parseFloat(nocData.TotDeduct).toFixed(2);
                                                    document.getElementById("hr-deductions").setAttribute("value", parseFloat(nocData.TotDeduct).toFixed(2));
                                                }


                                    });
                                    if (nocData.final_submit_hr === 'Y') {
                                                            $('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                                            // Disable Final Submit button
                                                        }
                                }
                            },
                                // error: function () {
                                //     alert('Error fetching NOC data.');
                                // }
                            });

                          
                            function populateFormFields(nocData) {

                                // Initialize total amount variable
                                let totalAmount = 0;

                                // 1. Sim Submitted
                                if (nocData.ItSS === 'Y') {
                                    $('input[name="sim_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItSS === 'N') {
                                    $('input[name="sim_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="sim_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="sim_recovery_amount"]').val(nocData.ItSS_Amt);
                                totalAmount += parseFloat(nocData.ItSS_Amt) || 0;  // Add to total
                                $('input[name="sim_remarks"]').val(nocData.ItSS_Remark);


                                // 2. Company Handset Submitted
                                if (nocData.ItCHS === 'Y') {
                                    $('input[name="handset_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItCHS === 'N') {
                                    $('input[name="handset_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="handset_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="handset_recovery_amount"]').val(nocData.ItCHS_Amt);
                                totalAmount += parseFloat(nocData.ItCHS_Amt) || 0;  // Add to total
                                $('input[name="handset_remarks"]').val(nocData.ItCHS_Remark);

                                // 3. Laptop / Desktop Handover
                                if (nocData.ItLDH === 'Y') {
                                    $('input[name="laptop_handover[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItLDH === 'N') {
                                    $('input[name="laptop_handover[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="laptop_handover[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="laptop_recovery_amount"]').val(nocData.ItLDH_Amt);
                                totalAmount += parseFloat(nocData.ItLDH_Amt) || 0;  // Add to total
                                $('input[name="laptop_remarks"]').val(nocData.ItLDH_Remark);

                                // 4. Camera Submitted
                                if (nocData.ItCS === 'Y') {
                                    $('input[name="camera_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItCS === 'N') {
                                    $('input[name="camera_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="camera_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="camera_recovery_amount"]').val(nocData.ItCS_Amt);
                                totalAmount += parseFloat(nocData.ItCS_Amt) || 0;  // Add to total
                                $('input[name="camera_remarks"]').val(nocData.ItCS_Remark);

                                // 5. Datacard Submitted
                                if (nocData.ItDC === 'Y') {
                                    $('input[name="datacard_submitted[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItDC === 'N') {
                                    $('input[name="datacard_submitted[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="datacard_submitted[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="datacard_recovery_amount"]').val(nocData.ItDC_Amt);
                                totalAmount += parseFloat(nocData.ItDC_Amt) || 0;  // Add to total
                                $('input[name="datacard_remarks"]').val(nocData.ItDC_Remark);

                                // 6. Email Account Blocked
                                if (nocData.ItEAB === 'Y') {
                                    $('input[name="email_blocked[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItEAB === 'N') {
                                    $('input[name="email_blocked[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="email_blocked[]"][value="NA"]').prop('checked', true);
                                }
                                $('input[name="email_recovery_amount"]').val(nocData.ItEAB_Amt);
                                totalAmount += parseFloat(nocData.ItEAB_Amt) || 0;  // Add to total
                                $('input[name="email_remarks"]').val(nocData.ItEAB_Remark);

                                // 7. Mobile No. Disabled/Transferred
                                if (nocData.ItMND === "Y") {
                                    $('input[name="mobile_disabled[]"][value="Yes"]').prop('checked', true);
                                } else if (nocData.ItMND === "N") {
                                    $('input[name="mobile_disabled[]"][value="No"]').prop('checked', true);
                                } else {
                                    $('input[name="mobile_disabled[]"][value="NA"]').prop('checked', true); // Default to NA if no value
                                }
                                $('input[name="mobile_recovery_amount"]').val(nocData.ItMND_Amt);
                                totalAmount += parseFloat(nocData.ItMND_Amt) || 0;  // Add to total
                                $('input[name="mobile_remarks"]').val(nocData.ItMND_Remark);
                                // 8. Any remarks
                                $('input[name="any_remarks"]').val(nocData.ItOth_Remark);

                                // Display the total amount
                                // $('#total-amount-it').text('Total Amount: ' + totalAmount.toFixed(2));

                                // localStorage.setItem('totalAmountIT', totalAmount);
                                // Handle final submit or draft submit
                                // if (nocData.final_submit_it === 'Y') {
                                //     $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                //     // Hide the "Save as Draft" and "Final Submit" buttons
                                //     $('.modal-footer #save-draft-btn-it').hide();
                                //     $('.modal-footer #final-submit-btn-it').hide();
                                // }
                            }

                        });

                    });
                });

// hr clearance end 

//revert back button 


document.getElementById('revertBackButton').addEventListener('click', function() {
    var empSepId = $('input[name="EmpSepId"]').val(); // Get EmpSepId value

    // Show loading spinner
    $('#loader').show();

    fetch('{{ route('send.email') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ EmpSepId: empSepId })
    })
    .then(response => response.json())
    .then(response => {
        $('#loader').hide(); // Hide loading spinner
        if (response.success) {
            toastr.success(response.message, 'Success', {
                "positionClass": "toast-top-right", 
                "timeOut": 3000 
            });
        $('#loader').hide(); // Hide loading spinner

        } else {
            toastr.error(response.message, 'Error', {
                "positionClass": "toast-top-right", 
                "timeOut": 3000 
            });
        $('#loader').hide(); // Hide loading spinner

          
        }
    })
    .catch(error => {
        $('#loader').hide(); // Hide loading spinner
        toastr.error('An error occurred while processing the request.', 'Error', {
            "positionClass": "toast-top-right", 
            "timeOut": 5000 
        });
    });
});
$(document).ready(function() {
        // Apply the filter when the dropdown selection changes
        $('#acctFilter').change(function() {
            var selectedStatus = $(this).val(); // Get the selected status

            // Filter the table rows based on the selected status
            $('#accttable tbody tr').each(function() {
                var rowStatus = $(this).data('status'); // Get the status from the data-status attribute

                // If no status is selected or if the status matches the selected one, show the row
                if (selectedStatus === "" || selectedStatus == rowStatus) {
                    $(this).show(); // Show matching rows
                } else {
                    $(this).hide(); // Hide non-matching rows
                }
            });
        });

        // Trigger the change event to apply the default filter when the page loads
        $('#acctFilter').trigger('change');
    });


    $('#accttable').DataTable({
        searching: true, // Enables the search box
        ordering:false,
    });


</script>

<style>
    #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.spinner-border {
    width: 3rem;
    height: 3rem;
}
</style>

