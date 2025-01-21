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
                                    <div class="card-header">
                                        <h5><b>Account NOC Clearance Form</b></h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <!-- IT Clearance Table -->
                                        <table class="table table-bordered">

                                            @foreach($approvedEmployees as $data)
                                                                            <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
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
                                                                                    <th>Clearance Status</th>
                                                                                    <th>Clearance form</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                @php
                                                                                    $index = 1;
                                                                                @endphp
                                                                                <tr>
                                                                                    <td>{{ $index++ }}</td>
                                                                                    <td>{{ $data->EmpCode }}</td>

                                                                                    <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td>
                                                                                    <!-- Employee Name -->
                                                                                    <td>{{ $data->DepartmentName }}</td> <!-- Employee Name -->
                                                                                    <td>{{ $data->EmailId_Vnr }}</td> <!-- Employee Name -->

                                                                                    <td>{{ 
                                                                    $data->Emp_ResignationDate
                                                    ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y')
                                                    : 'Not specified' 
                                                                }}</td>
                                                                                    <td>{{ 
                                                                    $data->Emp_RelievingDate
                                                    ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y')
                                                    : 'Not specified' 
                                                                }}</td>
                                                                                    <td>
                                                                                        <span>{{ $data->Rep_Approved == 'Y' ? 'Approved' : 'Rejected' }}</span>

                                                                                    </td>
                      
                                                                            <td>@php
                                                                                // Fetch the record from the hrm_employee_separation_nocrep table using EmpSepId
                                                                                $nocRecord = \DB::table('hrm_employee_separation_nocacc')->where('EmpSepId', $data->EmpSepId)->first();
                                                                            @endphp

                                                                            @if($nocRecord)
                                                                                @if($nocRecord->draft_submit_acct === 'Y')
                                                                                    <span class="text-warning">Drafting</span>
                                                                                @elseif($nocRecord->final_submit_acct === 'Y')
                                                                                    <span class="text-danger">Submitted</span>
                                                                                @else
                                                                                    <span class="text-warning">Pending</span>
                                                                                @endif
                                                                            @else
                                                                                <span class="text-warning">Pending</span>
                                                                            @endif
                                                                        </td>
                                                                                    <td>
                                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsAcct"
                                                                                            data-emp-name="{{ $data->Fname }}  {{ $data->Sname }} {{ $data->Lname }}"
                                                                                            data-designation="{{ $data->DesigName }}"
                                                                                            data-emp-code="{{ $data->EmpCode }}"
                                                                                            data-department="{{ $data->DepartmentName }}"
                                                                                            data-emp-sepid="{{ $data->EmpSepId }}">
                                                                                            form click
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                            @endforeach
                                        </table>

                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
				@include('employee.footerbottom')
            </div>
        </div>
    </div>
          
            <div class="modal fade show" id="clearnsdetailsAcct" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
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
                                        <a class="nav-link active" id="logistics-tab" data-bs-toggle="tab" href="#logistics" role="tab" aria-controls="logistics" aria-selected="false">Logistics Clearance Form</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="hr-tab" data-bs-toggle="tab" href="#hr" role="tab" aria-controls="hr" aria-selected="true">HR Clearance Form</a>
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
                                    <div class="tab-pane fade show " id="hr" role="tabpanel" aria-labelledby="hr-tab">
                                    <button type="button" onclick="window.history.back()" style="margin:5px;float:inline-end; padding: 5px 10px; font-size: 10px; background-color: #c4d9db; border: 1px solid #ccc; border-radius: 4px; cursor: pointer; color: #333;">Revert Back</button>

                                    <form id="hrnocfrom" method="POST">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">
                    
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
                    
                                        <!-- <div class="clformbox">
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
                                        </div> -->
                    
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
                                                <h5>Earnings(Rs.)</h5>
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
                    
                                                <!-- <div class="col-md-6 mb-3">
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
                                                </div> -->
                                            </div>
                                        </div>
                    
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Deduction Amount(Rs.)</h5>
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
                    
                                                    <!-- <div class="mb-3 col-md-6">
                                                        <label for="serviceBondRecovery" class="form-label"><b>Recovery Towards Service Bond</b></label>
                                                        <input type="text" class="form-control" placeholder="Enter Recovery Towards Service Bond" id="serviceBondRecovery" name="service_bond_recovery">
                                                    </div> -->
                    
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
                                    <div class="tab-pane fade show active" id="logistics" role="tabpanel" aria-labelledby="logistics-tab">
                                        <form id="logisticsnocform">
                                            @csrf
                                            <input type="hidden" name="EmpSepId">

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
                                                <div id="total-amount-log" style="margin:0px 60px 10px 0px; font-weight: bold;float:inline-end;"></div>

                                                <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">
                                                Parties Clearance 
                                                <a class="effect-btn btn btn-success squer-btn sm-btn" id="add-more">
                                                    Add <i class="fas fa-plus mr-2"></i>
                                                </a>
                                            <div id="parties-container">
                                                <!-- Dynamically generated party sections will appear here -->
                                            </div>


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
                                                    <input type="checkbox" name="AccECP" value="NA"> NA
                                                </label>
                                                <label style="margin-right: 10px;">
                                                    <input type="checkbox" name="AccECP" value="Yes"> Yes
                                                </label>
                                                <label>
                                                    <input type="checkbox" name="AccECP" value="No"> No
                                                </label>
                                            </div>
                                        </div>

                                            <div class="clrecoveramt" style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                <div style="flex: 1;">
                                                    <label><b>Deduct</b></label><br>
                                                    <input class="form-control" type="number" name="AccECP_Amt" placeholder="Enter Deduct Amount">
                                                </div>
                                                <div style="flex: 1;">
                                                    <label><b>Earning</b></label><br>
                                                    <input class="form-control" type="number" name="AccECP_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccIPS" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccIPS" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccIPS" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccIPS_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccIPS_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccAMS" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccAMS" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccAMS" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccAMS_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccAMS_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccSAR" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccSAR" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccSAR" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccSAR_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccSAR_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccWGR" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccWGR" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccWGR" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccWGR_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccWGR_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccSB" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccSB" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccSB" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccSB_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccSB_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccTDSA" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccTDSA" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccTDSA" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccTDSA_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccTDSA_Amt2" placeholder="Enter Earning Amount">
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
                                                            <input type="checkbox" name="AccRecy" value="NA"> NA
                                                        </label>
                                                        <label style="margin-right: 10px;">
                                                            <input type="checkbox" name="AccRecy" value="Yes"> Yes
                                                        </label>
                                                        <label>
                                                            <input type="checkbox" name="AccRecy" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Deduct, Earning, and Remarks in the same row -->
                                                <div style="display: flex; width: 100%; gap: 20px; align-items: center;">
                                                    <div style="flex: 1;">
                                                        <label><b>Deduct</b></label><br>
                                                        <input class="form-control" type="number" name="AccRecy_Amt" placeholder="Enter Deduct Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Earning</b></label><br>
                                                        <input class="form-control" type="number" name="AccRecy_Amt2" placeholder="Enter Earning Amount">
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label><b>Remarks</b></label><br>
                                                        <input class="form-control" type="text" name="AccRecy_Remark" placeholder="Enter remarks">
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- <div class="clformbox">
                                                <div class="formlabel" style="width:40%;">
                                                    <label style="width:100%;"><b>Parties Details</b></label><br>
                                                    <input type="text" class="form-control mb-2" name="AccAO8" placeholder="Enter your parties name"><br>
                                                    <input type="radio" name="AccAO_Txt8" value="NA"><label>NA</label>
                                                    <input type="radio" name="AccAO_Txt8" value="Yes"><label>Yes</label>
                                                    <input type="radio" name="AccAO_Txt8" value="No"><label>No</label>
                                                </div>
                                                <div class="clrecoveramt" style="width:26%;">
                                                    <label style="width:100%;"><b>Deduct</b></label><br>
                                                    <input class="form-control" type="text" name="AccAO_Amt8" placeholder="Enter Deduct Amount">
                                                </div>
                                                <div class="clrecoveramt" style="width:26%;">
                                                    <label style="width:100%;"><b>Earning</b></label><br>
                                                    <input class="form-control" type="text" name="AccAO2_Amt8" placeholder="Enter Earning Amount">
                                                </div>
                                                <div class="clreremarksbox">
                                                    <input class="form-control mt-2" type="text" name="AccAO_Remark8" placeholder="Enter remarks">
                                                </div>
                                            </div> -->
                            
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
                                                            <input type="number" id="it-earnings" name="itearnings" value="0" style="width: 100px;" />
                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="it-deductions" name="itdeductions" value="0" style="width: 100px;" />
                                                        </td>
                                                    </tr>

                                                    <!-- Logistics Earnings and Deductions -->
                                                    <tr>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">Reporting Manager </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="logistics-earnings"  name="logisticsearnings" value="0" style="width: 100px;" />
                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="logistics-deductions" name="logisticsdeductions" value="0" style="width: 100px;" />
                                                        </td>
                                                    </tr>

                                                    <!-- Account Earnings and Deductions -->
                                                    <tr>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">Account</td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="account-earnings" name="accountearnings" value="0" style="width: 100px;" />
                                                        </td>
                                                        <td style="padding: 10px; border: 1px solid #ddd;">
                                                            <input type="number" id="account-deductions" name="accountdeductions" value="0" style="width: 100px;" />
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
                            // Calculate the total earnings and deductions
                            const totalEarnings = parseFloat($('#logistics-earnings').val()) + parseFloat($('#account-earnings').val()) + parseFloat($('#it-earnings').val());
                                const totalDeductions = parseFloat($('#account-deductions').val()) + parseFloat($('#logistics-deductions').val()) + parseFloat($('#it-deductions').val());
                                formData.append('total_earnings', totalEarnings.toFixed(0));  // Append total earnings
                                formData.append('total_deductions', totalDeductions.toFixed(0));  // Append total deductions

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

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        $('#assetRequestForm')[0].reset();  // Reset the form
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

                        // Event listener for "Save as Draft" button
                        saveDraftButton.addEventListener('click', function (event) {
                            handleFormSubmission('save-draft-btn-acct', event); // Pass 'save-draft-btn' as the button ID
                        });

                        // Event listener for "Final Submit" button
                        submitButton.addEventListener('click', function (event) {
                            handleFormSubmission('final-submit-btn-acct', event); // Pass 'final-submit-btn' as the button ID
                        });

                    });
                    $('#clearnsdetailsAcct').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var empName = button.data('emp-name');
                    var designation = button.data('designation');
                    var empCode = button.data('emp-code');
                    var department = button.data('department');
                    var empSepId = button.data('emp-sepid');

                    // Update the modal's content with employee data
                    var modal = $(this);
                    modal.find('.emp-name').text(empName);
                    modal.find('.designation').text(designation);
                    modal.find('.emp-code').text(empCode);
                    modal.find('.department').text(department);


                    // Set the EmpSepId in a hidden input field to send with the form
                    modal.find('input[name="EmpSepId"]').val(empSepId);
                    $('#logistics-tab').trigger('click');

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
                    $('input[name="AccECP"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccECP === 'N') {
                    $('input[name="AccECP"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccECP"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccECP_Amt"]').val(nocData.AccECP_Amt);
                $('input[name="AccECP_Amt2"]').val(nocData.AccECP_Amt2);
                acctEarnings += parseFloat(nocData.AccECP_Amt || 0);
                acctDeductions += parseFloat(nocData.AccECP_Amt2 || 0);
                $('input[name="AccECP_Remark"]').val(nocData.AccECP_Remark);

                // 2. IPS Account (AccIPS)
                if (nocData.AccIPS === 'Y') {
                    $('input[name="AccIPS"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccIPS === 'N') {
                    $('input[name="AccIPS"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccIPS"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccIPS_Amt"]').val(nocData.AccIPS_Amt);
                $('input[name="AccIPS_Amt2"]').val(nocData.AccIPS_Amt2);
                acctEarnings += parseFloat(nocData.AccIPS_Amt || 0);
                acctDeductions += parseFloat(nocData.AccIPS_Amt2 || 0);
                $('input[name="AccIPS_Remark"]').val(nocData.AccIPS_Remark);

                // 3. AMS (AccAMS)
                if (nocData.AccAMS === 'Y') {
                    $('input[name="AccAMS"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccAMS === 'N') {
                    $('input[name="AccAMS"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccAMS"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccAMS_Amt"]').val(nocData.AccAMS_Amt);
                $('input[name="AccAMS_Amt2"]').val(nocData.AccAMS_Amt2);
                acctEarnings += parseFloat(nocData.AccAMS_Amt || 0);
                acctDeductions += parseFloat(nocData.AccAMS_Amt2 || 0);
                $('input[name="AccAMS_Remark"]').val(nocData.AccAMS_Remark);

                // 4. SAR (AccSAR)
                if (nocData.AccSAR === 'Y') {
                    $('input[name="AccSAR"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccSAR === 'N') {
                    $('input[name="AccSAR"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccSAR"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccSAR_Amt"]').val(nocData.AccSAR_Amt);
                $('input[name="AccSAR_Amt2"]').val(nocData.AccSAR_Amt2);
                acctEarnings += parseFloat(nocData.AccSAR_Amt || 0);
                acctDeductions += parseFloat(nocData.AccSAR_Amt2 || 0);
                $('input[name="AccSAR_Remark"]').val(nocData.AccSAR_Remark);

                // 5. WGR (AccWGR)
                if (nocData.AccWGR === 'Y') {
                    $('input[name="AccWGR"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccWGR === 'N') {
                    $('input[name="AccWGR"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccWGR"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccWGR_Amt"]').val(nocData.AccWGR_Amt);
                $('input[name="AccWGR_Amt2"]').val(nocData.AccWGR_Amt2);
                acctEarnings += parseFloat(nocData.AccWGR_Amt || 0);
                acctDeductions += parseFloat(nocData.AccWGR_Amt2 || 0);
                $('input[name="AccWGR_Remark"]').val(nocData.AccWGR_Remark);

                // 6. SB (AccSB)
                if (nocData.AccSB === 'Y') {
                    $('input[name="AccSB"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccSB === 'N') {
                    $('input[name="AccSB"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccSB"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccSB_Amt"]').val(nocData.AccSB_Amt);
                $('input[name="AccSB_Amt2"]').val(nocData.AccSB_Amt2);
                acctEarnings += parseFloat(nocData.AccSB_Amt || 0);
                acctDeductions += parseFloat(nocData.AccSB_Amt2 || 0);
                $('input[name="AccSB_Remark"]').val(nocData.AccSB_Remark);

                // 7. TDS Adjustment (AccTDSA)
                if (nocData.AccTDSA === 'Y') {
                    $('input[name="AccTDSA"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccTDSA === 'N') {
                    $('input[name="AccTDSA"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccTDSA"][value="NA"]').prop('checked', true);
                }
                $('input[name="AccTDSA_Amt"]').val(nocData.AccTDSA_Amt);
                $('input[name="AccTDSA_Amt2"]').val(nocData.AccTDSA_Amt2);
                acctEarnings += parseFloat(nocData.AccTDSA_Amt || 0);
                acctDeductions += parseFloat(nocData.AccTDSA_Amt2 || 0);
                $('input[name="AccTDSA_Remark"]').val(nocData.AccTDSA_Remark);

                // 8. Recyclable Material (AccRecy)
                if (nocData.AccRecy === 'Y') {
                    $('input[name="AccRecy"][value="Yes"]').prop('checked', true);
                } else if (nocData.AccRecy === 'N') {
                    $('input[name="AccRecy"][value="No"]').prop('checked', true);
                } else {
                    $('input[name="AccRecy"][value="NA"]').prop('checked', true);
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
                // Get total amount from localStorage
    let totalAmountFromOtherTab = localStorage.getItem('totalAmountIT');
    console.log(totalAmountFromOtherTab);
    if (totalAmountFromOtherTab !== null) {
        console.log("Total Amount from IT Tab: " + totalAmountFromOtherTab);
    }

    // Get total amount from localStorage for logistics
    let totalAmountFromOtherTabLOG = localStorage.getItem('totalAmountLOG');
    console.log(totalAmountFromOtherTabLOG);
    if (totalAmountFromOtherTabLOG !== null) {
        console.log("Total Amount from Logistics Tab: " + totalAmountFromOtherTabLOG);
    }

    // Ensure the variables are numbers before using them
    acctEarnings = parseFloat(acctEarnings) || 0; // Default to 0 if undefined or NaN
    acctDeductions = parseFloat(acctDeductions) || 0;
    ITEarnings = parseFloat(ITEarnings) || 0;
    totalAmountFromOtherTab = parseFloat(totalAmountFromOtherTab) || 0;
    LOGEarnings = parseFloat(LOGEarnings) || 0;
    totalAmountFromOtherTabLOG = parseFloat(totalAmountFromOtherTabLOG) || 0;

    // Check if nocData matches the values in localStorage
    if (
        nocData.IT_Earn === totalAmountFromOtherTab &&
        nocData.Rep_Earn === totalAmountFromOtherTabLOG
    ) {
        console.log("NOC Data matches with LocalStorage data.");

        // If nocData matches, use these values
        $('#account-earnings').val(acctEarnings.toFixed(0));  // Format to 0 decimal places
        $('#account-deductions').val(acctDeductions.toFixed(0));  // Format to 0 decimal places

        $('#it-earnings').val(ITEarnings.toFixed(0));  // Format to 0 decimal places
        $('#it-deductions').val(totalAmountFromOtherTab.toFixed(0));  // Format to 0 decimal places

        $('#logistics-earnings').val(LOGEarnings.toFixed(0));  // Format to 0 decimal places
        $('#logistics-deductions').val(totalAmountFromOtherTabLOG.toFixed(0));  // Format to 0 decimal places
    } else {
        console.log("NOC Data is different from LocalStorage values.");

        // If nocData doesn't match, display the nocData values
        $('#account-earnings').val(nocData.Acc_Earn);  
        $('#account-deductions').val(nocData.Acc_Deduct);  

        $('#it-earnings').val(nocData.IT_Earn);  
        $('#it-deductions').val(nocData.IT_Deduct);  

        $('#logistics-earnings').val(nocData.Rep_Earn);  
        $('#logistics-deductions').val(nocData.Rep_Deduct);  
    }

    // Function to calculate and update the total earnings and deductions
    function updateTotals() {
        const totalEarnings = parseFloat($('#logistics-earnings').val()) + parseFloat($('#account-earnings').val()) + parseFloat($('#it-earnings').val());
        const totalDeductions = parseFloat($('#account-deductions').val()) + parseFloat($('#logistics-deductions').val()) + parseFloat($('#it-deductions').val());

        // Update total earnings and deductions (to 0 decimal places)
        $('#total-earnings').text(totalEarnings.toFixed(0));
        $('#total-deductions').text(totalDeductions.toFixed(0));
    }

    // Bind the update function to input changes
    $('#account-earnings, #account-deductions, #it-earnings, #it-deductions, #logistics-earnings, #logistics-deductions').on('input', function() {
        updateTotals(); // Recalculate and update totals on any input change
    });

    // Initial calculation
    updateTotals();
}


                });

                    // acct ends

//Logistics start
// Attach a single event listener to a parent container (in this case, 'parties-container')
document.getElementById('parties-container').addEventListener('change', function(event) {
    // Check if the clicked element is a checkbox
    if (event.target && event.target.type === 'checkbox') {
        const checkbox = event.target;
        const name = checkbox.name;
        
        // Uncheck all checkboxes in the same group, except the one that was just clicked
        document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
            if (otherCheckbox !== checkbox) {
                otherCheckbox.checked = false;
            }
        });
    }
});
document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        // Get the name of the group (all checkboxes with the same name)
        const name = this.name;
        
        // Uncheck all checkboxes in the group, except the one that was just clicked
        document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
            if (otherCheckbox !== checkbox) {
                otherCheckbox.checked = false;
            }
        });
    });
});
// Event delegation for remove buttons
document.getElementById('parties-container').addEventListener('click', function(event) {
    // Check if the clicked element is a remove button
    if (event.target && event.target.classList.contains('remove-party')) {
        const partyId = event.target.getAttribute('data-party-id');
        const partyElement = document.getElementById(partyId);
        
        // Remove the party section from the DOM
        if (partyElement) {
            partyElement.remove();
        }
    }
});

// // Function to add more dynamic party fields
// document.getElementById('add-more').addEventListener('click', function() {
//     // Create the HTML for the new party section
//     const partyHTML = `
//         <div class="clformbox" id="party-${partyCount}">
//             <div class="formlabel">
//                 <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyCount}" placeholder="Enter your party name"><br>
//                 <input type="checkbox" name="Parties_${partyCount}_docdata" value="NA"><label>NA</label>
//                 <input type="checkbox" name="Parties_${partyCount}_docdata" value="Yes"><label>Yes</label>
//                 <input type="checkbox" name="Parties_${partyCount}_docdata" value="No"><label>No</label>
//             </div>
//             <div class="clrecoveramt">
//                 <input class="form-control" type="number" name="Parties_${partyCount}_Amt" placeholder="Enter recovery amount">
//             </div>
//             <div class="clreremarksbox">
//                 <input class="form-control" type="text" name="Parties_${partyCount}_Remark" placeholder="Enter remarks">
//             </div>
//             <button type="button" class="btn btn-danger remove-party" style="margin:10px;" data-party-id="party-${partyCount}">-</button>
//         </div>
//     `;

//     // Insert the new party HTML into the container
//     const partiesContainer = document.getElementById('parties-container');
//     partiesContainer.insertAdjacentHTML('beforeend', partyHTML);

//     // Increment party count
//     partyCount++;
// });
document.getElementById('add-more').addEventListener('click', function() {
    // Find the last party section in the container
    const partiesContainer = document.getElementById('parties-container');
    const lastParty = partiesContainer.querySelector('.clformbox:last-of-type');

    // Determine the next party count based on the last party's ID
    let nextPartyCount = 1;
    if (lastParty) {
        const lastPartyId = lastParty.id;  // Get the ID of the last party (e.g., party-1, party-2)
        nextPartyCount = parseInt(lastPartyId.split('-')[1]) + 1;  // Extract the number and increment by 1
    }

    // Create the HTML for the new party section, using the unique nextPartyCount for the name attribute
    const partyHTML = `
        <div class="clformbox" id="party-${nextPartyCount}">
            <div class="formlabel">
                <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${nextPartyCount}" placeholder="Enter your party name"><br>
                <input type="checkbox" name="Parties_${nextPartyCount}_docdata" value="NA"><label>NA</label>
                <input type="checkbox" name="Parties_${nextPartyCount}_docdata" value="Yes"><label>Yes</label>
                <input type="checkbox" name="Parties_${nextPartyCount}_docdata" value="No"><label>No</label>
            </div>
            <div class="clrecoveramt">
                <input class="form-control" type="number" name="Parties_${nextPartyCount}_Amt" placeholder="Enter recovery amount">
            </div>
            <div class="clreremarksbox">
                <input class="form-control" type="text" name="Parties_${nextPartyCount}_Remark" placeholder="Enter remarks">
            </div>
            <button type="button" class="btn btn-danger remove-party" style="margin:10px;" data-party-id="party-${nextPartyCount}">-</button>
        </div>
    `;

    // Insert the new party HTML into the container
    partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
});

document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('logisticsnocform');
    const saveDraftButton = document.getElementById('save-draft-btn-log');
    const submitButton = document.getElementById('final-submit-btn-log');
    const partiesContainer = document.getElementById('parties-container');
    let partyCount = 1;

    // Function to handle form submission
    function handleFormSubmission(buttonId, event) {
        event.preventDefault();

        const formData = new FormData(form);
        const formId = form.id;
        formData.append('form_id', formId);
        formData.append('button_id', buttonId);

        // Send form data to the Laravel controller using fetch
        fetch("{{ route('submit.noc.clearance') }}", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {  // Use 'data' instead of 'response'
                                    // Show a success toast notification with custom settings
                                    toastr.success(data.message, 'Success', {
                                        "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                                        "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                                    });

                                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                                    setTimeout(function () {
                                        $('#assetRequestForm')[0].reset();  // Reset the form
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

        // Event listener for "Save as Draft" button
        saveDraftButton.addEventListener('click', function(event) {
            handleFormSubmission('save-draft-btn-log', event); // Pass 'save-draft-btn' as the button ID
        });

        // Event listener for "Final Submit" button
        submitButton.addEventListener('click', function(event) {
            handleFormSubmission('final-submit-btn-log', event); // Pass 'final-submit-btn' as the button ID
        });


        // Function to add more dynamic party fields
        // Update the event listener for adding new party fields
document.getElementById('add-more').addEventListener('click', function() {
    // Create the HTML for the new party section, using the unique partyCount for the name attribute
    const partyHTML = `
        <div class="clformbox" id="party-${partyCount}">
            <div class="formlabel">
                <input style="width:100%;" class="form-control mb-2" type="text" name="Parties_${partyCount}" placeholder="Enter your party name"><br>
                <input type="checkbox" name="Parties_${partyCount}_docdata" value="NA"><label>NA</label>
                <input type="checkbox" name="Parties_${partyCount}_docdata" value="Yes"><label>Yes</label>
                <input type="checkbox" name="Parties_${partyCount}_docdata" value="No"><label>No</label>
            </div>
            <div class="clrecoveramt">
                <input class="form-control" type="number" name="Parties_${partyCount}_Amt" placeholder="Enter recovery amount">
            </div>
            <div class="clreremarksbox">
                <input class="form-control" type="text" name="Parties_${partyCount}_Remark" placeholder="Enter remarks">
            </div>
            <button type="button" class="btn btn-danger remove-party" style="margin:10px;" data-party-id="party-${partyCount}">-</button>
        </div>
    `;

    // Insert the new party HTML into the container
    const partiesContainer = document.getElementById('parties-container');
    partiesContainer.insertAdjacentHTML('beforeend', partyHTML);

    // Increment party count to ensure each new party gets a unique index
    partyCount++;
});
        // Event delegation for remove buttons
        document.getElementById('parties-container').addEventListener('click', function(event) {
            // Check if the clicked element is a remove button
            if (event.target && event.target.classList.contains('remove-party')) {
                const partyId = event.target.getAttribute('data-party-id');
                const partyElement = document.getElementById(partyId);
                
                // Remove the party section from the DOM
                if (partyElement) {
                    partyElement.remove();
                }
            }
        });

});


$(document).ready(function() {

    // Trigger the AJAX call when the form (or button) is clicked
    $('#logistics-tab').off('click').on('click', function() {
      
        var empSepId = $('input[name="EmpSepId"]').val();
        console.log(empSepId);

        // Perform AJAX request to get NOC data
        // Fetch additional data for this EmpSepId using an AJAX request
        $.ajax({
    url: '/get-noc-data/' + empSepId, // Assuming the endpoint is correct
    method: 'GET',
    success: function(response) {
        if (response.success) {
            var nocData = response.data;
            console.log(nocData);  // Log the data to verify it contains party info

            // Update the modal with employee info
            var modal = $(this);
            modal.find('.emp-name').text(nocData.empName);
            modal.find('.designation').text(nocData.designation);
            modal.find('.emp-code').text(nocData.empCode);
            modal.find('.department').text(nocData.department);
            modal.find('input[name="EmpSepId"]').val(empSepId);

            // Initialize total amount variable
            let totalAmountlog = 0;

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
            totalAmountlog += parseFloat(nocData.DDH_Amt) || 0;  // Add DDH amount to total

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
            totalAmountlog += parseFloat(nocData.TID_Amt) || 0;  // Add TID amount to total

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
            totalAmountlog += parseFloat(nocData.APTC_Amt) || 0;  // Add APTC amount to total

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

            totalAmountlog += parseFloat(nocData.HOAS_Amt) || 0;  // Add HOAS amount to total

            // Populate party fields dynamically
            let partyIndex = 1;
            while (nocData[`Prtis${partyIndex}`]) {
                // Dynamically populate party fields
                const partyHTML = `
                    <div class="clformbox" id="party-${partyIndex}">
                        <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
                            <label style="width: auto; margin-right: 10px;"><b>Party ${partyIndex}</b></label>
                            <div style="display: flex; align-items: center;">
                                <label style="margin-right: 10px;">
                                    <input type="checkbox" name="Parties_${partyIndex}_docdata" value="NA" ${nocData[`Prtis_${partyIndex}`] === 'NA' ? 'checked' : ''}> NA
                                </label>
                                <label style="margin-right: 10px;">
                                    <input type="checkbox" name="Parties_${partyIndex}_docdata" value="Yes" ${nocData[`Prtis_${partyIndex}`] === 'Y' ? 'checked' : ''}> Yes
                                </label>
                                <label>
                                    <input type="checkbox" name="Parties_${partyIndex}_docdata" value="No" ${nocData[`Prtis_${partyIndex}`] === 'N' ? 'checked' : ''}> No
                                </label>
                            </div>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="number" name="Parties_${partyIndex}_Amt" value="${nocData[`Prtis_${partyIndex}Amt`] || ''}" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="Parties_${partyIndex}_Remark" value="${nocData[`Prtis_${partyIndex}Remark`] || ''}" placeholder="Enter remarks" style="margin:10px;">
                        </div>
                    </div>
                `;
                const partiesContainer = document.getElementById('parties-container');
                partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
                
                // Add party amount to total
                //totalAmountlog += parseFloat(nocData[`Prtis_${partyIndex}Amt`]) || 0;
                
                partyIndex++;
            }

              // Display the total amount
              $('#total-amount-log').text('Total Amount: ' + totalAmountlog.toFixed(2));

            localStorage.setItem('totalAmountLOG', totalAmountlog);

            // Check if the final status is 'Y'
            if (nocData.final_submit_log === 'Y') {
                // Disable all form fields if the status is 'Y'
                $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                // Hide the "Save as Draft" and "Final Submit" buttons
                $('.modal-footer #save-draft-btn-log').hide();
                $('.modal-footer #final-submit-btn-log').hide();
            }
        }
    },
    error: function() {
        alert('Error fetching NOC data.');
    }
});
        // $.ajax({
        //     url: '/get-noc-data/' + empSepId, // Assuming the endpoint is correct
        //     method: 'GET',
        //     success: function(response) {
        //         if (response.success) {
        //             var nocData = response.data;
        //             console.log(nocData);  // Log the data to verify it contains party info

        //             // Update the modal with employee info
        //             var modal = $(this);
        //             modal.find('.emp-name').text(nocData.empName);
        //             modal.find('.designation').text(nocData.designation);
        //             modal.find('.emp-code').text(nocData.empCode);
        //             modal.find('.department').text(nocData.department);
        //             modal.find('input[name="EmpSepId"]').val(empSepId);

        //             // Populate checkboxes and input fields with the fetched data
        //         // 1. Handover of Data Documents etc (DDH)
        //         if (nocData.DDH === 'Y') {
        //             $('input[name="DDH[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
        //         } else if (nocData.DDH === 'N') {
        //             $('input[name="DDH[]"][value="No"]').prop('checked', true); // Check 'No'
        //         } else {
        //             $('input[name="DDH[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
        //         }
        //         $('input[name="DDH_Amt"]').val(nocData.DDH_Amt);
        //         $('input[name="DDH_Remark"]').val(nocData.DDH_Remark);

        //         // 2. Handover of ID Card (TID)
        //         if (nocData.TID === 'Y') {
        //             $('input[name="TID[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
        //         } else if (nocData.TID === 'N') {
        //             $('input[name="TID[]"][value="No"]').prop('checked', true); // Check 'No'
        //         } else {
        //             $('input[name="TID[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
        //         }
        //         $('input[name="TID_Amt"]').val(nocData.TID_Amt);
        //         $('input[name="TID_Remark"]').val(nocData.TID_Remark);

        //         // 3. Complete pending task (APTC)
        //         if (nocData.APTC === 'Y') {
        //             $('input[name="APTC[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
        //         } else if (nocData.APTC === 'N') {
        //             $('input[name="APTC[]"][value="No"]').prop('checked', true); // Check 'No'
        //         } else {
        //             $('input[name="APTC[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
        //         }
        //         $('input[name="APTC_Amt"]').val(nocData.APTC_Amt);
        //         $('input[name="APTC_Remark"]').val(nocData.APTC_Remark);

        //         // 4. Handover of Health Card (HOAS)
        //         if (nocData.HOAS === 'Y') {
        //             $('input[name="HOAS[]"][value="Yes"]').prop('checked', true); // Check 'Yes'
        //         } else if (nocData.HOAS === 'N') {
        //             $('input[name="HOAS[]"][value="No"]').prop('checked', true); // Check 'No'
        //         } else {
        //             $('input[name="HOAS[]"][value="NA"]').prop('checked', true); // Check 'NA' by default if no match
        //         }
        //         $('input[name="HOAS_Amt"]').val(nocData.HOAS_Amt);
        //         $('input[name="HOAS_Remark"]').val(nocData.HOAS_Remark);
        //         $('input[name="otherremark"]').val(nocData.Oth_Remark);
        //         $('#parties-container').empty();  // Empty the container to remove previous dynamic content

        //             // Repeat the same for other fields (TID, APTC, HOAS) ...

        //             // Populate party fields dynamically
        //             let partyIndex = 1;
        //             while (nocData[`Prtis${partyIndex}`]) {
        //                 // Dynamically populate party fields
        //                 const partyHTML = `
        //                         <div class="clformbox" id="party-${partyIndex}">
        //                         <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 20px;">
        //                         <label style="width: auto; margin-right: 10px;"><b>Party ${partyIndex}</b></label>
        //                         <div style="display: flex; align-items: center;">
        //                             <label style="margin-right: 10px;">
        //                                 <input type="checkbox" name="Parties_${partyIndex}_docdata" value="NA" ${nocData[`Prtis_${partyIndex}`] === 'NA' ? 'checked' : ''}> NA
        //                             </label>
        //                             <label style="margin-right: 10px;">
        //                                 <input type="checkbox" name="Parties_${partyIndex}_docdata" value="Yes" ${nocData[`Prtis_${partyIndex}`] === 'Y' ? 'checked' : ''}> Yes
        //                             </label>
        //                             <label>
        //                                 <input type="checkbox" name="Parties_${partyIndex}_docdata" value="No" ${nocData[`Prtis_${partyIndex}`] === 'N' ? 'checked' : ''}> No
        //                             </label>
        //                         </div>
        //                     </div>
        //                     <div class="clrecoveramt">
        //                         <input class="form-control" type="number" name="Parties_${partyIndex}_Amt" value="${nocData[`Prtis_${partyIndex}Amt`] || ''}" placeholder="Enter recovery amount">
        //                     </div>
        //                     <div class="clreremarksbox">
        //                         <input class="form-control" type="text" name="Parties_${partyIndex}_Remark" value="${nocData[`Prtis_${partyIndex}Remark`] || ''}" placeholder="Enter remarks" style="margin:10px;">
        //                     </div>
        //                 </div>
        //                 `;

                                            
        //                 const partiesContainer = document.getElementById('parties-container');

        //                 partiesContainer.insertAdjacentHTML('beforeend', partyHTML);
        //                 partyIndex++;
        //             }
        //             // Check if the final status is 'Y'
        //         if (nocData.final_submit_log === 'Y') {
        //             // Disable all form fields if the status is 'Y'
        //             $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
        //           // Hide the "Save as Draft" and "Final Submit" buttons
        //           $('.modal-footer #save-draft-btn-log').hide();
        //             $('.modal-footer #final-submit-btn-log').hide();
        //         }
        //         }
        //     },
        //     error: function() {
        //         alert('Error fetching NOC data.');
        //     }
        // });
    });
});

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

                            // Trigger the AJAX call when the form (or button) is clicked
                            $('#it-tab').click(function() {
                            
                            var empSepId = $('input[name="EmpSepId"]').val();
                            console.log(empSepId);

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
                                error: function () {
                                    alert('Error fetching NOC data.');
                                }
                            });

                            // Function to populate the form fields in the modal
                            // function populateFormFields(nocData) {
                            //     console.log(nocData);
                            //     // 1. Sim Submitted
                            //     if (nocData.ItSS === 'Y') {
                            //         $('input[name="sim_submitted[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItSS === 'N') {
                            //         $('input[name="sim_submitted[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="sim_submitted[]"][value="NA"]').prop('checked', true);
                            //     }
                            //     $('input[name="sim_recovery_amount"]').val(nocData.ItSS_Amt);
                            //     $('input[name="sim_remarks"]').val(nocData.ItSS_Remark);

                            //     // 2. Company Handset Submitted
                            //     if (nocData.ItCHS === 'Y') {
                            //         $('input[name="handset_submitted[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItCHS === 'N') {
                            //         $('input[name="handset_submitted[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="handset_submitted[]"][value="NA"]').prop('checked', true);
                            //     }
                            //     $('input[name="handset_recovery_amount"]').val(nocData.ItCHS_Amt);
                            //     $('input[name="handset_remarks"]').val(nocData.ItCHS_Remark);

                            //     // 3. Laptop / Desktop Handover
                            //     if (nocData.ItLDH === 'Y') {
                            //         $('input[name="laptop_handover[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItLDH === 'N') {
                            //         $('input[name="laptop_handover[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="laptop_handover[]"][value="NA"]').prop('checked', true);
                            //     }
                            //     $('input[name="laptop_recovery_amount"]').val(nocData.ItLDH_Amt);
                            //     $('input[name="laptop_remarks"]').val(nocData.ItLDH_Remark);

                            //     // 4. Camera Submitted
                            //     if (nocData.ItCS === 'Y') {
                            //         $('input[name="camera_submitted[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItCS === 'N') {
                            //         $('input[name="camera_submitted[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="camera_submitted[]"][value="NA"]').prop('checked', true);
                            //     }
                            //     $('input[name="camera_recovery_amount"]').val(nocData.ItCS_Amt);
                            //     $('input[name="camera_remarks"]').val(nocData.ItCS_Remark);

                            //     // 5. Datacard Submitted
                            //     if (nocData.ItDC === 'Y') {
                            //         $('input[name="datacard_submitted[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItDC === 'N') {
                            //         $('input[name="datacard_submitted[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="datacard_submitted[]"][value="NA"]').prop('checked', true);
                            //     }
                            //     $('input[name="datacard_recovery_amount"]').val(nocData.ItDC_Amt);
                            //     $('input[name="datacard_remarks"]').val(nocData.ItDC_Remark);

                            //     // 6. Email Account Blocked
                            //     if (nocData.ItEAB === 'Y') {
                            //         $('input[name="email_blocked[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItEAB === 'N') {
                            //         $('input[name="email_blocked[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="email_blocked[]"][value="NA"]').prop('checked', true);
                            //     }
                            //     $('input[name="email_recovery_amount"]').val(nocData.ItEAB_Amt);
                            //     $('input[name="email_remarks"]').val(nocData.ItEAB_Remark);

                            //     // 7. Mobile No. Disabled/Transferred
                            //     if (nocData.ItMND === "Y") {
                            //         $('input[name="mobile_disabled[]"][value="Yes"]').prop('checked', true);
                            //     } else if (nocData.ItMND === "N") {
                            //         $('input[name="mobile_disabled[]"][value="No"]').prop('checked', true);
                            //     } else {
                            //         $('input[name="mobile_disabled[]"][value="NA"]').prop('checked', true); // Default to NA if no value
                            //     }
                            //     $('input[name="mobile_recovery_amount"]').val(nocData.ItMND_Amt);
                            //     $('input[name="mobile_remarks"]').val(nocData.ItMND_Remark);
                            //     $('input[name="otherremark"]').val(nocData.Oth_Remark);

                            //     // 8. Any remarks
                            //     $('input[name="any_remarks"]').val(nocData.ItOth_Remark);
                            //     console.log(nocData.final_submit_it);
                            //     // Handle final submit or draft submit
                            //     // if (nocData.final_submit_it === 'Y') {
                            //     //     $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                            //     //     // Hide the "Save as Draft" and "Final Submit" buttons
                            //     //     $('.modal-footer #save-draft-btn-it').hide();
                            //     //                         $('.modal-footer #final-submit-btn-it').hide();
                            //     //     }
                            // }
                            function populateFormFields(nocData) {
                                console.log(nocData);

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
                                $('#total-amount-it').text('Total Amount: ' + totalAmount.toFixed(2));

                                localStorage.setItem('totalAmountIT', totalAmount);
                                // Handle final submit or draft submit
                                if (nocData.final_submit_it === 'Y') {
                                    $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Hide the "Save as Draft" and "Final Submit" buttons
                                    $('.modal-footer #save-draft-btn-it').hide();
                                    $('.modal-footer #final-submit-btn-it').hide();
                                }
                            }

                        });

                    });
// it clearance end 

//it clarance start 
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
                            $('#hr-tab').click(function() {
                            
                            var empSepId = $('input[name="EmpSepId"]').val();
                            console.log(empSepId);

                            // Fetch additional data for this EmpSepId using an AJAX request
                            $.ajax({
                                url: '/get-noc-data-hr/' + empSepId,  // Endpoint to get the NOC data
                                method: 'GET',
                                success: function(response) {
        if (response.success) {
            var nocData = response.data; // Data returned from backend
            console.log(nocData);

          
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
            
            // $('input[name="id_card_recovery_amount"]').val(nocData.id_card_recovery_amount);
            // $('input[name="id_card_remarks"]').val(nocData.id_card_remarks);

            $('input[name="visiting_recovery_amount"]').val(nocData.AdminVC_Amt);
            $('input[name="visiting_remarks"]').val(nocData.AdminVC_Remark);
            
            $('input[name="company_vehcile_recovery_amount"]').val(nocData.CV_Amt);
            $('input[name="company_vehcile_remarks"]').val(nocData.CV_Remark);

            // Filling other fields as well (add all the necessary fields like the worked days, notice period, and earnings)
            $('input[name="worked_days_without_notice"]').val(nocData.WorkDay);
            $('input[name="served_notice_period"]').val(nocData.NoticeDay);
            $('input[name="available_el_days"]').val(nocData.EnCashEL);
            $('input[name="total_worked_days"]').val(nocData.TotWorkDay);
            $('input[name="actual_notice_period"]').val(nocData.ServedDay);
            $('input[name="recoverable_notice_period"]').val(nocData.RecoveryDay);
            $('input[name="encashable_el_days"]').val(nocData.TotEL);
            $('input[name="partially_amount_paid"]').val(nocData.partially_amount_paid);

            // Earnings section
            $('input[name="basic_rate"]').val(nocData.Basic);
            $('input[name="basic_amount"]').val(nocData.Basic);
            
            $('input[name="hra_rate"]').val(nocData.HRA);
            $('input[name="hra_amount"]').val(nocData.HRA);
            
            $('input[name="car_allowance_rate"]').val(nocData.CarAllow);
            $('input[name="car_allowance_amount"]').val(nocData.CarAllow);
            
            $('input[name="bonus_rate"]').val(nocData.Bonus);
            $('input[name="bonus_amount"]').val(nocData.Bonus);
            
            $('input[name="special_allow_rate"]').val(nocData.special_allow_rate);
            $('input[name="special_allow_amount"]').val(nocData.special_allow_amount);

            $('input[name="lta_rate"]').val(nocData.lta_rate);
            $('input[name="lta_amount"]').val(nocData.lta_amount);
            
            $('input[name="medical_allow_rate"]').val(nocData.Mediclaim);
            $('input[name="medical_allow_amount"]').val(nocData.Mediclaim);
            
            $('input[name="child_edu_allow_rate"]').val(nocData.child_edu_allow_rate);
            $('input[name="child_edu_allow_amount"]').val(nocData.child_edu_allow_amount);

            // Deduction section
            $('input[name="pf_amount"]').val(nocData.PF);
            $('input[name="esic"]').val(nocData.ESIC);
            $('input[name="arrear_esic"]').val(nocData.ARR_ESIC);
            $('input[name="service_bond_recovery"]').val(nocData.service_bond_recovery);
            $('input[name="notice_period_recovery"]').val(nocData.NoticePay);
            $('input[name="notice_period_amount"]').val(nocData.NoticePay);
            $('input[name="voluntary_contribution"]').val(nocData.voluntary_contribution);
            $('input[name="relocation_allowance"]').val(nocData.RA_allow);
            $('input[name="nrs_deduction"]').val(nocData.nrs_deduction);
            $('input[name="total_deduction"]').val(nocData.TotDeduct);
            $('input[name="hr_remarks"]').val(nocData.HrRemark);
            if (nocData.final_submit_hr === 'Y') {
                                    $('input, select, button').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Disable Final Submit button
                                }
        }
    },
                                error: function () {
                                    alert('Error fetching NOC data.');
                                }
                            });

                          
                            function populateFormFields(nocData) {
                                console.log(nocData);

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
                                $('#total-amount-it').text('Total Amount: ' + totalAmount.toFixed(2));

                                localStorage.setItem('totalAmountIT', totalAmount);
                                // Handle final submit or draft submit
                                if (nocData.final_submit_it === 'Y') {
                                    $('input, select').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                                    // Hide the "Save as Draft" and "Final Submit" buttons
                                    $('.modal-footer #save-draft-btn-it').hide();
                                    $('.modal-footer #final-submit-btn-it').hide();
                                }
                            }

                        });

                    });
// it clearance end 


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

