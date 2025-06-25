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
                     <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                  </li>
                  <li class="breadcrumb-link active">Department NOC Form(IT)</li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <!-- Dashboard Start -->
   <div class="col-xl-12 col-lg-12 col-md-6 col-sm-12 col-12">
      <div class="card">
         <div class="card-header dflex justify-content-center align-items-center">
            <h5><b>IT NOC Clearance Form</b></h5>
            <form method="GET" action="{{ url()->current() }}">
               <select id="itFilter" name="it_status" style="float:right;">
                  <option value="">All</option>
                  <option value="N" {{ request()->get('it_status', 'N') == 'N' ? 'selected' : '' }}>Pending</option>
                  <option value="Y" {{ request()->get('it_status') == 'Y' ? 'selected' : '' }}>Submitted</option>
               </select>
            </form>
         </div>
         <div class="card-body table-responsive">
            <!-- IT Clearance Table -->
            <table class="table table-bordered" id="ittable">
               <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
               <thead>
   <tr>
      <th>EC</th>
      <th>Employee Name</th>
      <th>Department</th>
      <th>Email</th>
      <th>Resignation Date</th>
      <th>Relieving Date</th>
      <th>Resignation Approved</th>
      <th>Department NOC Status</th>
      <th>Log NOC Status</th>
      <th>IT NOC Status</th>
      <th>HR NOC Status</th>
      <th>Account NOC Status</th>
      <th>History</th>
      <th>Clearance Form</th>
   </tr>
</thead>
<tbody>
   @foreach($approvedEmployees as $data)
   <tr>
      <td>{{ $data->EmpCode }}</td>
      <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td>
      <td>{{ $data->department_name }}</td>
      <td>{{ $data->EmailId_Vnr }}</td>
      <td>{{ $data->Emp_ResignationDate ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y') : 'Not specified' }}</td>
      <td>{{ $data->Emp_RelievingDate ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y') : 'Not specified' }}</td>
      <td>
        @php
            $statusClass = match($data->Rep_Approved) {
                'Y' => 'text-success',  // Approved (Green)
                'N' => 'text-danger',   // No (Red)
                'C' => 'text-secondary', // Cancelled (Gray)
                'P' => 'text-warning',  // Pending (Yellow)
                default => 'text-muted'  // Fallback
            };

            $statusText = match($data->Rep_Approved) {
                'Y' => 'Approved',
                'N' => 'No',
                'C' => 'Cancelled',
                'P' => 'Pending',
                default => 'Unknown'
            };
        @endphp

        <span class="{{ $statusClass }}">{{ $statusText }}</span>
    </td>

      <!-- Department NOC Status -->
      <td>
         <span class="{{ $data->Rep_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->Rep_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>
      <!-- Log NOC Status -->
      <td>
         <span class="{{ $data->Log_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->Log_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>

      </td>
      <!-- IT NOC Status -->
      <!--<td>
         <span class="{{ $data->IT_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->IT_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>-->
      <td>
                            @php
                                $nocRecord = \DB::table('hrm_employee_separation_nocit')->where('EmpSepId', $data->EmpSepId)->first();
                            @endphp

                            @if($nocRecord)
                                @if($nocRecord->draft_submit_it === 'Y')
                                    <span class="text-warning">Draft</span>
                                @elseif($nocRecord->final_submit_it === 'Y')
                                    <span class="text-success">Submitted</span>
                                @elseif($data->IT_NOC == 'Y')
                                    <span class="text-success">Submitted</span>
                                @elseif($data->IT_NOC == 'N')
                                    <span class="text-warning">Pending</span>
                                @endif
                            @else
                                <span class="text-warning">Pending</span>
                            @endif
                        </td>
      <!-- HR NOC Status -->
      <td>
         <span class="{{ $data->HR_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->HR_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>
      <!-- Account NOC Status -->
      <td>
         <span class="{{ $data->Acc_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->Acc_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>
      <td>
      @php
                $employeeDetails = \DB::table('hrm_employee')
                    ->where('EmployeeID', $data->EmployeeID)
                    ->select('EmployeeID', 'fname', 'lname', 'sname', 'EmpCode')
                    ->first();
            @endphp
           
            @if($employeeDetails)
                    <a href="#" 
                    data-bs-toggle="modal" 
                    data-bs-target="#viewassetsHistoryModal" 
                    class="viewassetsHistory" 
                    data-employee-id="{{ $data->EmployeeID }}"
                    data-employee-name="{{ $employeeDetails->fname . ' ' . $employeeDetails->sname . ' ' . $employeeDetails->lname }}"
                    data-employee-code="{{ $employeeDetails->EmpCode }}">
                        <i class="fas fa-history"></i>
                    </a>
                @else
                    <span>Employee not found</span> <!-- You can display a fallback message here -->
                @endif
            </td>

      <!-- Clearance Form -->
      @if($data->HR_Approved == 'Y' && ($data->Rep_Approved == 'Y' || $data->Hod_Approved == 'Y'))
      <td>
         <a href="#" data-bs-toggle="modal" data-bs-target="#clearnsdetailsIT"
            data-emp-name="{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}"
            data-designation="{{ $data->designation_name }}"
            data-emp-code="{{ $data->EmpCode }}"
            data-department="{{ $data->department_name }}"
            data-emp-sepid="{{ $data->EmpSepId }}">
            Action
         </a>
      </td>
      @else
      <td>-</td>
      @endif
   </tr>
   @endforeach
</tbody>

            </table>
         </div>
      </div>
   </div>
   <div class="modal fade show" id="clearnsdetailsIT" tabindex="-1"
      aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle3">Departmental NOC Clearance Form
                  (IT)
               </h5>
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
               <!-- <form id="itnocform">
                  @csrf
                  <input type="hidden" name="EmpSepId">
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>1. Sim Submitted</b></label><br>
                          <input type="checkbox" name="sim_submitted[]" value="NA"><label>NA</label>
                          <input type="checkbox" name="sim_submitted[]" value="Yes"><label>Yes</label>
                          <input type="checkbox" name="sim_submitted[]" value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="sim_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="sim_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>2. Company Handset Submitted</b></label><br>
                          <input type="checkbox" name="handset_submitted[]"
                              value="NA"><label>NA</label>
                          <input type="checkbox" name="handset_submitted[]"
                              value="Yes"><label>Yes</label>
                          <input type="checkbox" name="handset_submitted[]"
                              value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="handset_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="handset_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>3. Laptop / Desktop Handover</b></label><br>
                          <input type="checkbox" name="laptop_handover[]" value="NA"><label>NA</label>
                          <input type="checkbox" name="laptop_handover[]"
                              value="Yes"><label>Yes</label>
                          <input type="checkbox" name="laptop_handover[]" value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="laptop_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="laptop_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>4. Camera Submitted</b></label><br>
                          <input type="checkbox" name="camera_submitted[]"
                              value="NA"><label>NA</label>
                          <input type="checkbox" name="camera_submitted[]"
                              value="Yes"><label>Yes</label>
                          <input type="checkbox" name="camera_submitted[]"
                              value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="camera_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="camera_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>5. Datacard Submitted</b></label><br>
                          <input type="checkbox" name="datacard_submitted[]"
                              value="NA"><label>NA</label>
                          <input type="checkbox" name="datacard_submitted[]"
                              value="Yes"><label>Yes</label>
                          <input type="checkbox" name="datacard_submitted[]"
                              value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="datacard_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="datacard_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <h5 style="border-bottom: 1px solid #ddd; margin-bottom: 10px;">ID's Password</h5>
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>6. Email Account Blocked</b></label><br>
                          <input type="checkbox" name="email_blocked[]" value="NA"><label>NA</label>
                          <input type="checkbox" name="email_blocked[]" value="Yes"><label>Yes</label>
                          <input type="checkbox" name="email_blocked[]" value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="email_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="email_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>7. Mobile No.
                                  Disabled/Transferred</b></label><br>
                          <input type="checkbox" name="mobile_disabled[]" value="NA"><label>NA</label>
                          <input type="checkbox" name="mobile_disabled[]"
                              value="Yes"><label>Yes</label>
                          <input type="checkbox" name="mobile_disabled[]" value="No"><label>No</label>
                      </div>
                      <div class="clrecoveramt">
                          <input class="form-control" type="number" name="mobile_recovery_amount"
                              placeholder="Enter recovery amount">
                      </div>
                      <div class="clreremarksbox">
                          <input class="form-control" type="text" name="mobile_remarks"
                              placeholder="Enter remarks">
                      </div>
                  </div>
                  
                  <div class="clformbox">
                      <div class="formlabel">
                          <label style="width:100%;"><b>Any remarks</b></label>
                      </div>
                      <div>
                          <input class="form-control" type="text" name="any_remarks"
                              placeholder="If any remarks enter here">
                      </div>
                  </div>
                  </form> -->
               <!-- <form id="itnocform">
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
                  
                  <div class="clformbox">
                      <div class="formlabel" style="display: flex; align-items: center; margin-bottom: 10px;">
                          <label style="width: 100%;"><b>Any remarks</b></label>
                      </div>
                      <div>
                          <input class="form-control" type="text" name="any_remarks" placeholder="If any remarks enter here">
                      </div>
                  </div>
                      </form> -->
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
               </form>
            </div>
            <!-- Submit buttons -->
            <div class="modal-footer">
               <button class="btn btn-primary" type="button" id="save-draft-btn-it">Save as
               Draft</button>
               <button class="btn btn-success" type="button" id="final-submit-btn-it">Final
               Submit</button>
            </div>
         </div>
      </div>
   </div>
    <!-- Modal assets history details -->
    <!-- <div id="viewassetsHistoryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewassetsHistoryModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="viewqueryModalLabel">Assets History Details</h5>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">×</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="row assets-request-box">
                     <h5>Assets Request History Details</h5>

                  <div class="col-md-6">
                     <div class="assets-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b></b></span>
                           <span class="float-end"><b></b> <b class="success"></b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start"> <b></b></span>
                           <span class="float-end"><b></b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start"></span>
                           <span class="float-end"></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start"></span>
                           <span class="float-end"><b></b></span>
                        </div>
                        <div class="mb-2">
                           <p></p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b></b> </span>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b></b> <a class="ms-2 link" href=""></a><a class="ms-3 link" href=""></a></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="assets-req-section">
                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                           <span class="float-start"><b></b></span>
                           <span class="float-end"><b></b> <b class="success"></b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start"><b></b></span>
                           <span class="float-end"><b></b></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start"></span>
                           <span class="float-end"></span>
                        </div>
                        <div class="float-start w-100">
                           <span class="float-start"> </span>
                           <span class="float-end"><b></b></span>
                        </div>
                        <div class="mb-2">
                           <p></p>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b></b> </span>
                        </div>
                        <div class="w-100" style="font-size:11px;">
                           <span class="me-3"><b></b> <a class="ms-2 link" href=""></a><a class="ms-3 link" href=""></a></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> -->
   <div id="viewassetsHistoryModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewassetsHistoryModalLabel"
      aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewqueryModalLabel">Assets History Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row assets-request-box">
                    <h5>Assets Request History Details</h5>

                    <!-- Assets Section -->
                    <div class="col-md-6">
                        
                    </div>
                    <br>

                    <!-- Official Assets Section (New Section) -->
                    <div class="col-md-6">
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   
   
   @include('employee.footer')
   <script>
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
                  $('#loader').hide();
      
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
      
          $('#clearnsdetailsIT').on('show.bs.modal', function (event) {
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
              function populateFormFields(nocData) {
                  console.log(nocData);
                  // 1. Sim Submitted
                  if (nocData.ItSS === 'Y') {
                      $('input[name="sim_submitted[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItSS === 'N') {
                      $('input[name="sim_submitted[]"][value="No"]').prop('checked', true);
                  } 
                  else {
                      $('input[name="sim_submitted[]"][value="NA"]').prop('checked', true);
                  } 
                 
                  $('input[name="sim_recovery_amount"]').val(nocData.ItSS_Amt);
                  $('input[name="sim_remarks"]').val(nocData.ItSS_Remark);
      
                  // 2. Company Handset Submitted
                  if (nocData.ItCHS === 'Y') {
                      $('input[name="handset_submitted[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItCHS === 'N') {
                      $('input[name="handset_submitted[]"][value="No"]').prop('checked', true);
                  } 
                  else  {
                      $('input[name="handset_submitted[]"][value="NA"]').prop('checked', true);
                  } 
                  
                  $('input[name="handset_recovery_amount"]').val(nocData.ItCHS_Amt);
                  $('input[name="handset_remarks"]').val(nocData.ItCHS_Remark);
      
                  // 3. Laptop / Desktop Handover
                  if (nocData.ItLDH === 'Y') {
                      $('input[name="laptop_handover[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItLDH === 'N') {
                      $('input[name="laptop_handover[]"][value="No"]').prop('checked', true);
                  }
                  else {
                      $('input[name="laptop_handover[]"][value="NA"]').prop('checked', true);
                  }
                  
                  $('input[name="laptop_recovery_amount"]').val(nocData.ItLDH_Amt);
                  $('input[name="laptop_remarks"]').val(nocData.ItLDH_Remark);
      
                  // 4. Camera Submitted
                  if (nocData.ItCS === 'Y') {
                      $('input[name="camera_submitted[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItCS === 'N') {
                      $('input[name="camera_submitted[]"][value="No"]').prop('checked', true);
                  } 
                  else  {
                      $('input[name="camera_submitted[]"][value="NA"]').prop('checked', true);
                  } 
                  
                  $('input[name="camera_recovery_amount"]').val(nocData.ItCS_Amt);
                  $('input[name="camera_remarks"]').val(nocData.ItCS_Remark);
      
                  // 5. Datacard Submitted
                  if (nocData.ItDC === 'Y') {
                      $('input[name="datacard_submitted[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItDC === 'N') {
                      $('input[name="datacard_submitted[]"][value="No"]').prop('checked', true);
                  } 
                  else  {
                      $('input[name="datacard_submitted[]"][value="NA"]').prop('checked', true);
                  } 
                  
                  $('input[name="datacard_recovery_amount"]').val(nocData.ItDC_Amt);
                  $('input[name="datacard_remarks"]').val(nocData.ItDC_Remark);
      
                  // 6. Email Account Blocked
                  if (nocData.ItEAB === 'Y') {
                      $('input[name="email_blocked[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItEAB === 'N') {
                      $('input[name="email_blocked[]"][value="No"]').prop('checked', true);
                  } 
                  else {
                      $('input[name="email_blocked[]"][value="NA"]').prop('checked', true);
                  } 
                  
                  $('input[name="email_recovery_amount"]').val(nocData.ItEAB_Amt);
                  $('input[name="email_remarks"]').val(nocData.ItEAB_Remark);
      
                  // 7. Mobile No. Disabled/Transferred
                  if (nocData.ItMND === "Y") {
                      $('input[name="mobile_disabled[]"][value="Yes"]').prop('checked', true);
                  } else if (nocData.ItMND === "N") {
                      $('input[name="mobile_disabled[]"][value="No"]').prop('checked', true);
                  }
                  else  {
                      $('input[name="mobile_disabled[]"][value="NA"]').prop('checked', true);
                  }
                   
                  $('input[name="mobile_recovery_amount"]').val(nocData.ItMND_Amt);
                  $('input[name="mobile_remarks"]').val(nocData.ItMND_Remark);
                  $('input[name="otherremark"]').val(nocData.Oth_Remark);
      
                  // 8. Any remarks
                  $('input[name="any_remarks"]').val(nocData.ItOth_Remark);
                  console.log(nocData.final_submit_it);
                  // Handle final submit or draft submit
                  if (nocData.final_submit_it === 'Y') {
                      $('input').prop('disabled', true);  // Disable all input fields, select boxes, and buttons
                      // Hide the "Save as Draft" and "Final Submit" buttons
                      $('.modal-footer #save-draft-btn-it').hide();
                      $('.modal-footer #final-submit-btn-it').hide();
                              }
              }
      
      
      
      
          });
      
      
      });
      
      document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
          checkbox.addEventListener('change', function () {
              // Get the name of the group (all checkboxes with the same name)
              const name = this.name;
              // Uncheck all checkboxes in the group
              document.querySelectorAll(`input[name="${name}"]`).forEach(function (otherCheckbox) {
                  if (otherCheckbox !== checkbox) {
                      otherCheckbox.checked = false;
                  }
              });
          });
      });
      
      // Apply Roboto font to the entire DataTable (header and body)
      $('#ittable').css('font-family', 'Roboto, sans-serif');
      $('#ittable').find('th, td').css('font-family', 'Roboto, sans-serif');
      
    function initializeTable(tableSelector, filterSelector, columnIndex, defaultFilterValue) {
      
      var table = $(tableSelector).DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
      });
      
      
      if (!defaultFilterValue) {
      $(filterSelector).val(''); 
      } else {
      
      $(filterSelector).val(defaultFilterValue);
      var defaultText = defaultFilterValue === 'Y' ? 'Submitted' : defaultFilterValue === 'N' ? 'Pending' : '';
      table.column(columnIndex).search(defaultText).draw();
      }
      
      
      $(filterSelector).on('change', function () {
      var filterValue = $(this).val();
      var filterText = '';
      
      
      if (filterValue === 'N') {
      filterText = 'Pending';
      } else if (filterValue === 'Y') {
      filterText = 'Submitted';
      }
      
      
      table.column(columnIndex).search(filterText).draw();
      });
      }
      
      
      $(document).ready(function () {
            var defaultFilter = '{{ request()->get('it_status', '') }}'; 
            
            initializeTable('#ittable', '#itFilter', 9, defaultFilter);
      });

      document.addEventListener('DOMContentLoaded', function () {
    // Attach click event to elements with the class "viewassetsHistory"
    document.querySelectorAll('.viewassetsHistory').forEach((element) => {
        element.addEventListener('click', function (e) {
            e.preventDefault();

            const employeeId = this.getAttribute('data-employee-id'); // Get the employee ID from the data attribute
            const modalBody = document.querySelector('#viewassetsHistoryModal .assets-request-box'); // Target modal body container

            const employeeName = this.getAttribute('data-employee-name'); // Get the employee name
            const employeeCode = this.getAttribute('data-employee-code'); // Get Employee Code

            const modalTitle = document.querySelector('#viewqueryModalLabel'); // Target modal title

            // Update the modal title with the employee name
            modalTitle.textContent = `Assets History Details - ${employeeName} (${employeeCode})`;

            // Clear previous content
            modalBody.innerHTML = '<p>Loading...</p>';

            // Fetch data from the server
            fetch(`/fetch-assets-history-it/${employeeId}`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((data) => {
                    let assetsContent = '';
                    let officialAssetsContent = '';

                    // Generate HTML content dynamically for different sections
                    data.assets.forEach((item) => {
                        const billUrl = `/Employee/AssetReqUploadFile/${item.ReqBillImgExtName || ''}`;
                        const assetUrl = `/Employee/AssetReqUploadFile/${item.ReqAssestImgExtName || ''}`;
                        console.log(item);

                        assetsContent += `
                            <div class="col-md-6">
                                <div class="assets-req-section">
                                    <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                                        <span class="float-start"><b>Name of assets: ${item.AssetName || '-'}</b></span>
                                        <span class="float-end"><b>Status:</b> <b class="${item.ApprovalStatus === 2 ? 'success' : 'danger'}">${item.ApprovalStatus === 2 ? 'Approved' : 'Pending'}</b></span>
                                    </div>
                                    <div class="float-start w-100">
                                        <span class="float-start">Request Amount: <b>${item.ReqAmt || '0.00'}/-</b></span>
                                        <span class="float-end">Approval Amount: <b>${item.ApprovalAmt || '0.00'}/-</b></span>
                                    </div>
                                    <div class="float-start w-100">
                                        <span class="float-start">Company: ${item.ComName || '-'}</span>

                                        <span class="float-end">Bal. Amount: <b>${item.MaxLimitAmt || '0.00'}/-</b></span>
                                        <br>
                                        <span class="float-start">Dealer: ${item.DealeName || '-'}</span>
                                    </div>
                                    <div class="float-start w-100">
                                        <span class="float-start">Model: ${item.ModelNo || '-'}</span>
                                        <span class="float-end">Price: <b>${item.Price || '0.00'}/-</b></span>
                                    </div>
                                    <div class="mb-2"><p>Remarks: "${item.AnyOtherRemark || '-'}"</p></div>
                                    <div class="w-100" style="font-size:11px;">
                                        <span class="me-3"><b>Request date:</b> ${formatDateddmmyyyy(item.ReqDate) || '-'}</span>
                                    </div>
                                    <div class="w-100" style="font-size:11px;">
                                        <span class="me-3"><b>Copy:</b> 
                                            <a class="ms-2 link" href="${billUrl}" target="_blank">Bill</a>
                                            <a class="ms-3 link" href="${assetUrl}" target="_blank">Assets</a>
                                        </span>
                                    </div>
                                </div>
                            </div>`;
                    });


                    data.official_assets.forEach((item) => {
                        
                            officialAssetsContent += `
                                <div class="col-md-6">
                                    <div class="assets-req-section">
                                        <div class="float-start w-100 pb-2 mb-2" style="border-bottom:1px solid #ddd;">
                                            <span class="float-start"><b>Name of assets: ${item.AssetName || '-'}</b></span>
                                            <span class="float-end"><b>Status:</b> <b class="${item.Status === 1 ? 'success' : 'danger'}">${item.Status === 1 ? 'Active' : 'Inactive'}</b></span>
                                        </div>
                                      
                                        <div class="float-start w-100">
                                            <span class="float-start">Company: ${item.AComName || '-'}</span>

                                            <br>
                                            <span class="float-start">Model No: ${item.AModelNo || '-'}</span>
                                            <span class="float-end">Price: <b>${item.APrice || '0.00'}/-</b></span>
                                        </div>
                                        <div class="float-start w-100">
                                            <span class="float-start">Dealer: ${item.ADealeName || '-'}</span>
                                            <br>
                                            <span class="float-start">Dealer Contact: ${item.ADealerContNo || '-'}</span>
                                        </div>
                                        <div class="float-start w-100">
                                            <span class="float-start">Purchase Date: ${formatDateddmmyyyy(item.APurDate) || '-'}</span>
                                            <span class="float-end">Expiry Date: ${formatDateddmmyyyy(item.AExpiryDate) || '-'}</span>
                                        </div>
                                        <div class="mb-2"><p>Remarks: "${item.AnyOtherRemark || '-'}"</p></div>
                                        <div class="w-100" style="font-size:11px;">
                                            <span class="me-3"><b>Allocated On:</b> ${formatDateddmmyyyy(item.AAllocate) || '-'}</span>
                                            <span class="me-3"><b>Returned On:</b> ${formatDateddmmyyyy(item.ADeAllocate) || '-'}</span>
                                        </div>
                                        
                                    </div>
                                </div>`;
                        });


                    // Update modal content by adding both asset sections
                    modalBody.innerHTML = `
                            <h4 style="color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 5px; margin-bottom: 15px;">
                                <b>Assets Request</b>
                            </h4>
                            <div class="row">
                                ${assetsContent ? assetsContent : '<p style="color: #6c757d;">No asset requests found.</p>'}
                            </div>

                            <hr style="border-top: 2px solid #ddd; margin: 25px 0;">

                            <h4 style="color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 5px; margin-bottom: 15px;">
                                <b>Official Assets</b>
                            </h4>
                            <div class="row">
                                ${officialAssetsContent ? officialAssetsContent : '<p style="color: #6c757d;">No official assets found.</p>'}
                            </div>
                        `;

                })
                .catch((error) => {
                    console.error('Error fetching asset history:', error);
                    modalBody.innerHTML = '<p>Failed to load asset history. Please try again later.</p>';
                });
        });
    });
});
function formatDateddmmyyyy(date) {
    if (!date || date === "0000-00-00" || date === "1970-01-01") return "-";
    
    const d = new Date(date);
    if (isNaN(d.getTime())) return "01/01/1970"; // Fallback for invalid dates

    return d.getDate().toString().padStart(2, '0') + '/' + 
           (d.getMonth() + 1).toString().padStart(2, '0') + '/' + 
           d.getFullYear();
}

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
      .dataTables_wrapper table.dataTable td{
      border: none !important;
      font-family: roboto;
      }
      #ittable thead tr th{
      border: 1px solid #cbcbcb;
      }
      .card-header {
      display: flex; 
      justify-content: center; 
      align-items: center; 
      text-align: center; 
      }
      .dflex {
      display: flex; 
      justify-content: space-between !important; 
      align-items: center; 
      width: 100%; 
      }
      .has-btn {
      margin-right: 10px; 
      }
   </style>