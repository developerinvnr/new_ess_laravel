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
                                    <li class="breadcrumb-link active">Department NOC Form</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                 @include('employee.menuteam')
                 <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><b>Departmental NOC Clearance Form (HR)</b></h5>
                    </div>
                    <div class="card-body table-responsive">
                        <!-- HR Clearance Table -->
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

                                                        <td>{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}</td> <!-- Employee Name -->
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
                                                        <td>
                                                                @if($data->EmpSepId && \DB::table('hrm_employee_separation_nocrep')->where('EmpSepId', $data->EmpSepId)->exists())
                                                                    @php
                                                                        // Get the draft_submit_log value for the EmpSepId
                                                                        $submitLogStatus = \DB::table('hrm_employee_separation_nocrep')
                                                                            ->where('EmpSepId', $data->EmpSepId)
                                                                            ->value('draft_submit_log');
                                                                    @endphp
                                                                    @if(is_null($submitLogStatus) || $submitLogStatus === 'N' || $submitLogStatus == 0)
                                                                        <span class="text-warning">Pending</span>
                                                                    @else
                                                                        <span class="text-success">Actioned</span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-warning">Pending</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                            <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsHR"
                                                                data-emp-name="{{ $data->Fname }} {{ $data->Lname }} {{ $data->Sname }}"
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

   
<div class="modal fade show" id="clearnsdetailsHR" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
    style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form (HR)</h5>
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

                <form id="hrnocfrom" method="POST">
                     @csrf
                     <input type="hidden" name="EmpSepId">

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>1. Block ESS Passward</b></label><br>
                            <input type="checkbox" name="block_ess_passward[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="block_ess_passward[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="block_ess_passward[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="block_ess_passward_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="block_ess_passward_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>2. Block Paypac Passward</b></label><br>
                            <input type="checkbox" name="block_paypac_passward[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="block_paypac_passward[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="block_paypac_passward[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="block_paypac_passward_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="block_paypac_passward_remarks" placeholder="Enter remarks">
                        </div>
                    </div>

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>3. Block Expro Passward</b></label><br>
                            <input type="checkbox" name="block_expro_passward[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="block_expro_passward[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="block_expro_passward[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="block_expro_passward_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="block_expro_passward_remarks" placeholder="Enter remarks">
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
                        <div class="formlabel">
                            <label style="width:100%;"><b>5. Visiting Card Submitted</b></label><br>
                            <input type="checkbox" name="visiting_submitted[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="visiting_submitted[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="visiting_submitted[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="visiting_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="visiting_remarks" placeholder="Enter remarks">
                        </div>
                    </div> 

                    <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>5. Company Vehicle Return</b></label><br>
                            <input type="checkbox" name="company_vehicle_return[]" value="NA"><label>NA</label>
                            <input type="checkbox" name="company_vehicle_return[]" value="Yes"><label>Yes</label>
                            <input type="checkbox" name="company_vehicle_return[]" value="No"><label>No</label>
                        </div>
                        <div class="clrecoveramt">
                            <input class="form-control" type="text" name="company_vehcile_recovery_amount" placeholder="Enter recovery amount">
                        </div>
                        <div class="clreremarksbox">
                            <input class="form-control" type="text" name="company_vehcile_remarks" placeholder="Enter remarks">
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

                    <!-- <div class="clformbox">
                        <div class="formlabel">
                            <label style="width:100%;"><b>Any remarks</b></label>
                        </div>
                        <div>
                            <input class="form-control" type="text" name="otheremark" placeholder="if any remarks enter here">
                        </div>
                    </div> -->
                </form>
            </div>
           
            <div class="modal-footer">
                                <button class="btn btn-primary" type="button" id="save-draft-btn-hr">Save as Draft</button>
                                <button class="btn btn-success" type="button" id="final-submit-btn-hr">Final Submit</button>
                            </div>
            
        </div>
    </div>
</div>

    
@include('employee.footer');
<script>
$('#clearnsdetailsHR').on('show.bs.modal', function (event) {
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


    // Fetch additional data for this EmpSepId using an AJAX request
    $.ajax({
    url: '/get-noc-data-hr/' + empSepId, // Assuming the endpoint is correct
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
    error: function() {
        alert('Error fetching NOC data.');
    }
});

});

// Get the form and buttons
const form = document.getElementById('hrnocfrom');
const saveDraftButton = document.getElementById('save-draft-btn-hr');
const submitButton = document.getElementById('final-submit-btn-hr');
// Function to handle form submission
function handleFormSubmission(event, buttonId) {
    // Prevent the form from submitting normally
    event.preventDefault(); 

    // Collect form data
    const formData = new FormData(form);
    const formId = form.id;  // This will be 'departmentnocfrom'
    formData.append('form_id', formId);  // Add the form id to the form data

    // Add the button ID (either 'save-draft-btn' or 'final-submit-btn')
    formData.append('button_id', buttonId);

    // Send data to the controller using fetch
    fetch("{{ route('submit.noc.clearance.hr') }}", {
        method: "POST",  // Use POST method
        body: formData,  // Send form data
    })
    .then(response => response.json())  // Parse the JSON response
    .then(data => {
        // Handle the response here (e.g., show success message)
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

// Event listener for the "Save as Draft" button
saveDraftButton.addEventListener('click', function(event) {
    handleFormSubmission(event, 'save-draft-btn-hr');  // Pass the event and 'save-draft-btn' as the button ID
});

// Event listener for the "Final Submit" button
submitButton.addEventListener('click', function(event) {
    handleFormSubmission(event, 'final-submit-btn-hr');  // Pass the event and 'final-submit-btn' as the button ID
});

document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Get the name of the group (all checkboxes with the same name)
            const name = this.name;
            // Uncheck all checkboxes in the group
            document.querySelectorAll(`input[name="${name}"]`).forEach(function(otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                }
            });
        });
    });

</script>
