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
      <div class="main-content">
         @include('employee.head')
         <!-- Page Title Start -->
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
               <div class="page-title-wrapper">
                  <div class="breadcrumb-list">
                     <ul>
                        <li class="breadcrumb-link">
                           <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                        </li>
                        <li class="breadcrumb-link active">My Team - Eligibility & CTC</li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <!-- Dashboard Start -->
         @include('employee.menuteam')
         <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
               <div class="card ad-info-card-">
                  <div class="card-header">
                     <div class="">
                        <h5 class="float-start"><b>Eligibility/CTC</b></h5>
                        @if($isReviewer)
                        <div class="flex-shrink-0" style="float:right;">
                           <form method="GET" action="{{ route('teameligibility') }}">
                              @csrf
                              <div class="form-check form-switch form-switch-right form-switch-md">
                                 <label for="hod-view" class="form-label text-muted mt-1 mr-1 ml-2" style="float:right;">HOD/Reviewer</label>
                                 <input 
                                 class="form-check-input" 
                                 type="checkbox" 
                                 name="hod_view" 
                                 id="hod-view" 
                                 {{ request()->has('hod_view') ? 'checked' : '' }} 
                                 onchange="toggleLoader(); this.form.submit();" 
                                 >
                              </div>
                           </form>
                        </div>
                        @endif
                     </div>
                  </div>
                  <div class="card-body" style="overflow-y: scroll;overflow-x: hidden;">
                     <!-- Table to display basic employee data -->
                     <table class="table text-center" id="eligibilityTable">
                        <thead>
                           <tr>
                               <th rowspan="2">Sno.</th>
                               <th rowspan="2">EC</th>
                               <th rowspan="2">Name</th>
                               <th rowspan="2">Designation</th>
                               <th rowspan="2">Grade</th>
                               <th colspan="5" style="text-align: center;">CTC</th>
                               <th colspan="5" style="text-align: center;">Eligibility</th> <!-- Updated colspan for Eligibility -->
                           </tr>
                           <tr>
                               <th>Yearly Gross Amt.</th>
                               <th>Fixed CTC</th>
                               <th>More</th>
                               <th style="text-align:center;">DA</th>
                               <th>Mobile Handset Eligibility</th>
                               <th colspan="2" style="text-align: center;">Mode/Class outside HQ</th> <!-- Group Vehicle related fields -->
                               <th>More</th>
                           </tr>
                       </thead>
                       
                        <tbody>
                           <?php
                              $indeselig = 1;
                              ?>
                           @foreach($eligibility as $index => $eligibilityDatas)
                           @foreach($eligibilityDatas as  $eligibilityData)
                           <tr>
                              <td>{{ $indeselig ++ }}</td>
                              <td  style="text-align:left;">{{ $eligibilityData->EC }}</td>
                              <td style="text-align:left;">{{ $eligibilityData->Fname }} {{ $eligibilityData->Sname }} {{ $eligibilityData->Lname }}</td>
                              <td  style="text-align:left;">{{ $eligibilityData->designation_name }}</td>
                              <td>{{$eligibilityData->grade_name}}</td>
                              <td>{{ formatToIndianRupees($eligibilityData->GrossAnnualSalary, 0) }}</td>
                              <td>{{ formatToIndianRupees($eligibilityData->TotalCTC, 0) }}</td>
                              <td>
                                 <a href="javascript:void(0)"
                                    onclick="fetchCtcData({{ $eligibilityData->EmployeeID }})"
                                    style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                    <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                                 </a>
                              </td>
                              <td>{{ $eligibilityData->DA_Outside_Hq ?? '-' }}</td>
                              <td>{{ $eligibilityData->Mobile_Hand_Elig ?? '-' }}</td>
                              <!-- Train/Bus Field -->
                              @if($eligibilityData->Train_Allow == "Y")
                              <td><b>Train/Bus - </b>{{ $eligibilityData->Train_Class . ' ' . ($eligibilityData->Train_Rmk ?? 'N/A') }}</td>
                              @else
                              <td>N/A</td>
                              <!-- If Train/Bus is not allowed, show N/A -->
                              @endif
                              <!-- Flight Field -->
                              @if($eligibilityData->Flight_Allow == "Y")
                              <td><b>Flight - </b>{{ $eligibilityData->Flight_Class . ' / ' . ($eligibilityData->Flight_Rmk ?? 'N/A') }}</td>
                              @else
                              <td>N/A</td>
                              <!-- If Flight is not allowed, show N/A -->
                              @endif
                              <td>
                                 <a href="javascript:void(0)"
                                    onclick="fetchEligibilityData({{ $eligibilityData->EmployeeID }})"
                                    style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                    <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                                 </a>
                              </td>
                           </tr>
                           @endforeach
                           @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal to display eligibility details -->
   <div class="modal fade" id="eligibilitydetails" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalCenterTitle3">Employee Eligibility Details</h5>
               <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <!-- Dynamic data will be inserted here -->
               <div class="row">
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                           <h4 class="has-btn">Lodging Entitlements</h4>
                           <p>(Actual with upper limits per day)</p>
                        </div>
                        <div class="card-body align-items-center">
                           <ul class="eligibility-list">
                              <li>City Category A:  <span class="p-0">/-</span><span id="lodgingA"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                              <li>City Category B: <span class="p-0">/-</span><span id="lodgingB"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                              <li>City Category C: <span class="p-0">/-</span><span id="lodgingC"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                           </ul>
                        </div>
                     </div>
                     <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                           <h4 class="has-btn">Insurance</h4>
                           <p>(Sum Insured)</p>
                        </div>
                        <div class="card-body">
                           <ul class="eligibility-list">
                              <li><strong>Health Insurance:</strong><span id="health_ins"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                              <li><strong>Group Term Life Insurance:</strong><span id="group_term"></span><span><i class="fas fa-rupee-sign"></i></span></li>
                           </ul>
                        </div>
                     </div>
                     <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                           <h4 class="has-btn">Gratuity / Deduction</h4>
                        </div>
                        <div class="card-body">
                           <ul class="gratuity-section">
                              <li>Gratuity - <span style="float: right; color: #DC7937;">AS per Law</span></li>
                              <li>Deduction - <span style="float: right; color: #DC7937;">AS per Law</span></li>
                           </ul>
                           <p style="color: #686464;">(Provident Fund/ ESIC/ Tax on Employment/ Income Tax/ Any dues to company(if any)/ Advances)</p>
                        </div>
                     </div>
                     <!-- More eligibility sections as needed -->
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                     <div class="card chart-card">
                        <div class="card-header ctc-head-title">
                           <h4 class="has-btn">Travel Eligibility</h4>
                           <p>(For Official Purpose Only)</p>
                        </div>
                        <div class="card-body">
                           <ul class="eligibility-list">
                              <li id="twheelerSection">
                                 <strong>2 Wheeler:</strong> 
                                 <!-- <span class="p-0">/-</span> -->
                                 <span id="twheeler">
                                    <p></p>
                                 </span>
                                 <!-- <span><i class="fas fa-rupee-sign"></i></span> -->
                              </li>
                              <li><strong>4 Wheeler:</strong> <span id="fwheeler"></span></li>
                              <li id="classoutside"><strong>Mode/Class outside HQ:</strong> <span id="outsideHq"></span></li>
                           </ul>
                        </div>
                     </div>
                     <div class="card chart-card" id="mobileeligibility">
                        <div class="card-header eligibility-head-title">
                           <h4 class="has-btn">Mobile Eligibility</h4>
                           <p>(Subject to submission of bills)</p>
                        </div>
                        <div class="card-body">
                           <ul class="eligibility-list">
                              <li>Mobile Handset Eligibility: <span id="handset"></span></li>
                           </ul>
                        </div>
                     </div>
                     <div class="card chart-card">
                        <div class="card-header eligibility-head-title">
                           <h4 class="has-btn">Daily Allowances</h4>
                           <p></p>
                        </div>
                        <div class="card-body align-items-center">
                           <ul class="eligibility-list">
                              <li  id="daHqsection">DA@HQ: <span id="daHq"></span> <span>/- Per Day</span></li>
                              <li>DA Outside HQ: <span id="daOutsideHq"></span></li>
                           </ul>
                        </div>
                     </div>
                     <!-- Add more sections like Gratuity / Deduction if needed -->
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Modal ctc-->
   <div class="modal fade" id="ctcModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="ctcModalLabel"> CTC Details - <span id="employeeNamectc"></span></h5>
               <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <!-- Monthly Components -->
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="card chart-card">
                        <div class="card-header">
                           <h4 class="has-btn">Monthly Components</h4>
                        </div>
                        <div class="card-body dd-flex align-items-center">
                           <ul class="ctc-section" id="monthly-components">
                              <li>
                                 <div class="ctc-title">Basic</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="BAS_Value"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">HRA</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="HRA_Value">12,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Bonus <sup>1</sup></div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Bonus1_Value">5,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Special Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="SpecialAllowance_Value">2,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Gross Monthly Salary</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Gross_Monthly_Salary">55,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">DA</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="DA"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrears</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arreares"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Leave Encash</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="LeaveEncash"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Car Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Car_Allowance"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Incentive</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Incentive"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Variable Reimbursement</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="VarRemburmnt"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Variable Adjustment</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="VariableAdjustment"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">City Compensatory Allowance (CCA)</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="CCA"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Relocation Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="RA"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Basic</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Basic"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear HRA</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Hra"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Special Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Spl"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Conveyance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Conv"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">CEA</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="YCea"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">MR</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="YMr"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">LTA</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="YLta"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Car Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Car_Allowance_Arr"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Leave Encash</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_LvEnCash"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Bonus</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Bonus"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear LTA Reimbursement</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_LTARemb"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Relocation Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_RA"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear Performance Pay</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_PP"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Bonus Adjustment</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Bonus_Adjustment"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Performance Incentive</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="PP_Inc"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">National Pension Scheme</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="NPS"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Provident Fund</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Tot_Pf_Employee"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">TDS</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="TDS"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">ESIC</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="ESCI_Employee"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">NPS Contribution</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="NPS_Value"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear PF</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Pf"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Arrear ESIC</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Arr_Esic"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Voluntary Contribution</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="VolContrib"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Deduct Adjustment</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="DeductAdjmt"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Recovery Special Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="RecSplAllow"></b></div>
                              </li>
                              <li>
                                 <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Net Monthly Salary</div>
                                 <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Net_Monthly_Salary">48,500</b></div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  <!-- Annual Components -->
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="card chart-card">
                        <div class="card-header ctc-head-title">
                           <h4 class="has-btn">Annual Components</h4>
                           <p>(Tax saving components which shall be reimbursed on production of documents)</p>
                        </div>
                        <div class="card-body dd-flex align-items-center">
                           <ul class="ctc-section" id="annual-components">
                              <li>
                                 <div class="ctc-title">Leave Travel Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="LTA_Value">12,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Children Education Allowance</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="ChildEduAllowance_Value">2,400</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Annual Gross Salary</div>
                                 <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="AnnualGrossSalary_Value">660,000</b></div>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="card chart-card">
                        <div class="card-header ctc-head-title">
                           <h4 class="has-btn">Other Annual Components</h4>
                           <p>(Statutory Components)</p>
                        </div>
                        <div class="card-body dd-flex align-items-center">
                           <ul class="ctc-section" id="other-annual-components">
                              <li>
                                 <div class="ctc-title">Estimated Gratuity <sup>2</sup></div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="Gratuity_Value">50,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Employer's PF Contribution</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="EmployerPF_Value">5,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Mediclaim Policy Premiums</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="MediclaimPolicy_Value">3,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Fixed CTC</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="FixedCTC_Value">720,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title">Performance Pay</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="PerformancePay_Value">25,000</b></div>
                              </li>
                              <li>
                                 <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC</div>
                                 <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="TotalCTC_Value">775,000</b></div>
                              </li>
                           </ul>
                        </div>
                     </div>
                     <div class="card chart-card">
                        <div class="card-header">
                           <h4 class="has-btn">Benefits</h4>
                        </div>
                        <div class="card-body dd-flex align-items-center">
                           <ul class="ctc-section" id="additional-benefit">
                              <li>
                                 <div class="ctc-title">Insurance Policy Premium</div>
                                 <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2" id="InsurancePremium_Value">3,000</b></div>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Notes Section -->
               <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12">
                     <p><b>Notes</b></p>
                     <ol id="notes">
                        <li>Bonus shall be paid as per The Code of Wages Act, 2019</li>
                        <li>The Gratuity to be paid as per The Code on Social Security, 2020.</li>
                        <li>Performance Pay</li>
                     </ol>
                     <b>Performance Pay</b>
                     <ol>
                        <li>Performance Pay is an annually paid variable component of CTC, paid in July salary.</li>
                        <li>This amount is indicative of the target variable pay, actual pay-out will vary based on the performance of Company and Individual.</li>
                        <li>It is linked with Company performance (as per fiscal year) and Individual Performance (as per appraisal period for minimum 6 months working, pro-rata basis if < 1 year working).</li>
                        <li>The calculation shall be based on the pre-defined performance measures at both, Company & Individual level.</li>
                     </ol>
                     <p>For more details refer to the Company’s Performance Pay policy.<br><br><b>Important</b><br>This is a confidential page not to be discussed openly with others. You shall be personally responsible for any leakage of information regarding your compensation.</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</body>
@include('employee.footer')
<?php
   function formatToIndianRupees($number) {
       // Remove decimals
       $number = round($number);
   
       // Convert the number to string
       $numberStr = (string)$number;
   
       // Handle case when the number is less than 1000 (no commas needed)
       if (strlen($numberStr) <= 3) {
           return $numberStr;
       }
   
       // Break the number into two parts: the last 3 digits and the rest
       $lastThreeDigits = substr($numberStr, -3);
       $remainingDigits = substr($numberStr, 0, strlen($numberStr) - 3);
   
       // Add commas every two digits in the remaining part
       $remainingDigits = strrev(implode(',', str_split(strrev($remainingDigits), 2)));
   
       // Combine the two parts and return
       return $remainingDigits . ',' . $lastThreeDigits;
   }
   
   ?>
<script>
    var table = $('#eligibilityTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": false,
      "autoWidth": false,
      "pageLength": 10,
      "lengthMenu": [10, 25, 50, 100],
    });
   function fetchEligibilityData(employee_id) {
   console.log(employee_id);
   // Make an AJAX call to fetch eligibility data
   fetch(`/employee-eligibility/${employee_id}`)
       .then(response => response.json())
       .then(data => {
           if (data.error) {
               alert(data.error);
               return;
           }
   
             // Function to update or hide sections based on data
       function updateRowOrHide(rowId, value) {
           const row = document.getElementById(rowId);
           const section = row ? row.closest('li') : null;
           if (!value || value === "0" || value === "0.00" || value === "" || value === "NA") {
               if (section) section.style.display = 'none'; // Hide the row if no valid data
           } else {
               if (row) row.innerText = value; // Show and update the row if data exists
               if (section) section.style.display = ''; // Ensure row is visible
           }
       }
       // Manually add 'twheeler' value with specific formatting
   function updateTwheeler(value) {
       console.log(value);
       const twheelerElement = document.getElementById('twheeler');
       const section = twheelerElement ? twheelerElement.closest('li') : null;
   
       if (value && value !== "0" && value !== "0.00" && value !== "" && value !== "NA") {
           const pContent = twheelerElement.querySelector('p') ? twheelerElement.querySelector('p').innerText : ''; // Preserve the <p> content
           twheelerElement.innerHTML = `<p>${value} /Km (Approval based for official use)</p>`;  // Append the new value
   
           if (section) section.style.display = ''; // Show the section if the value is valid
       } else {
           if (section) section.style.display = 'none'; // Hide the section if value is invalid
       }
   }
    function updatefourwheeler(value) {
       console.log(value);
       const fourwheeler = document.getElementById('fwheeler');
       const section = fourwheeler ? fourwheeler.closest('li') : null;
   
       if (value && value !== "0" && value !== "0.00" && value !== "" && value !== "NA") {
           const pContent = fourwheeler.querySelector('p') ? fourwheeler.querySelector('p').innerText : ''; // Preserve the <p> content
           fourwheeler.innerHTML = `<p>${value} /Km (Approval based for official use)</p>`;  // Append the new value
   
           if (section) section.style.display = ''; // Show the section if the value is valid
       } else {
           if (section) section.style.display = 'none'; // Hide the section if value is invalid
       }
   }
   
       // Populate fields using updateRowOrHide
       updateRowOrHide('lodgingA', data.Lodging_CategoryA);
       updateRowOrHide('lodgingB', data.Lodging_CategoryB);
       updateRowOrHide('lodgingC', data.Lodging_CategoryC);
       
       // Check DA_Inside_Hq and hide section if not available
       updateRowOrHide('daHq', data.DA_Inside_Hq);
       document.getElementById('daHqsection').style.display = data.DA_Inside_Hq ? '' : 'none';
   
       // Other fields
       updateRowOrHide('daOutsideHq', data.DA_Outside_Hq);
       updateTwheeler( data.Travel_TwoWeeKM);
       updatefourwheeler(data.Travel_FourWeeKM);
       updateRowOrHide('group_term', data.Health_Insurance);
       updateRowOrHide('health_ins', data.Term_Insurance);
   
       // Check Mode_Travel_Outside_Hq and hide section if not available
       updateRowOrHide('outsideHq', data.Mode_Travel_Outside_Hq);
       document.getElementById('classoutside').style.display = data.Mode_Travel_Outside_Hq ? '' : 'none';
   
       // Handle Mobile Eligibility
       if (data.Mobile_Hand_Elig === "N") {
           document.getElementById('mobileeligibility').style.display = 'none'; // Hide section
       } else {
           //document.getElementById('mobileeligibility').style.display = 'block'; // Show section
           document.getElementById('handset').innerText = (data.Mobile_Hand_Elig === "Y") ? "Eligible" : "Not Eligible";
       }   
           // Open the modal
           var myModal = new bootstrap.Modal(document.getElementById('eligibilitydetails'), {
               keyboard: false
           });
           myModal.show();
       })
       .catch(error => {
           console.error('Error fetching eligibility data:', error);
       });
   }
   
   function fetchCtcData(EmployeeID) {
   // Make an AJAX call to fetch CTC data
   fetch(`/employee-ctc/${EmployeeID}`)
       .then(response => response.json())
       .then(data => {
           console.log(data);
           if (data.error) {
               alert(data.error); // If there's an error, show an alert
               return;
           }
   
                   // Helper function to format numbers to integers (without decimals)
                   function formatToInteger(value) {
                       // Ensure value is a valid number
                       if (value || value === 0) {
                           // Return the number as an integer, removing any decimals
                           return Math.floor(value).toString();  // Removing decimal part
                       }
                       return 'N/A';  // Return 'N/A' if value is null, undefined, or not a number
                   }
                   // Helper function to update or hide a row
                   function updateRowOrHide(rowId, value) {
                           const row = document.getElementById(rowId);
                           
                           // Check if the element exists
                           if (!row) {
                               console.warn(`Element with ID '${rowId}' not found.`);
                               return; // Skip if the element is missing
                           }
   
                   const listItem = row.closest('li'); // Find the <li> element containing this row
                   if (value === null || value === undefined || value === "" || value === 0 || value === "0.00") {
                       listItem.style.display = "none"; // Hide the entire <li> element if there's no valid value
                   } else {
                       row.innerText = formatToInteger(value); // Format and update the value
                       listItem.style.display = ""; // Show the <li> element if there's a valid value
                   }
               }
   
               // Populate the modal with the fetched CTC data
               document.getElementById('employeeNamectc').innerText = 
                   `${data?.Fname ?? ''} ${data?.Sname ?? ''} ${data?.Lname ?? ''}`.trim();
   
               // Monthly Components
               updateRowOrHide('BAS_Value', data?.BAS_Value);
               updateRowOrHide('HRA_Value', data?.HRA_Value);
               updateRowOrHide('Bonus1_Value', data?.Bonus_Month);
               updateRowOrHide('SpecialAllowance_Value', data?.SPECIAL_ALL_Value);
               updateRowOrHide('Gross_Monthly_Salary', data?.Tot_GrossMonth);
               updateRowOrHide('PF_Value', data?.PF_Employee_Contri_Value);
               updateRowOrHide('Net_Monthly_Salary', data?.NetMonthSalary_Value);
   
               // Additional Benefits
               updateRowOrHide('ChildEduAllowance_Value', data?.CHILD_EDU_ALL_Value);
   
               // Annual Components
               updateRowOrHide('LTA_Value', data?.LTA_Value);
               updateRowOrHide('InsurancePremium_Value', data?.EmpAddBenifit_MediInsu_value);
   
               // Performance-related Details
               updateRowOrHide('AnnualGrossSalary_Value', data?.Tot_Gross_Annual);
               updateRowOrHide('Gratuity_Value', data?.GRATUITY_Value);
               updateRowOrHide('EmployerPF_Value', data?.PF_Employer_Contri_Annul);
               updateRowOrHide('MediclaimPolicy_Value', data?.Mediclaim_Policy);
               updateRowOrHide('FixedCTC_Value', data?.Tot_CTC);
               updateRowOrHide('PerformancePay_Value', data?.VariablePay);
               updateRowOrHide('TotalCTC_Value', data?.TotCtc);
   
               // Additional Fields
               updateRowOrHide('DA', data?.DA_Value);
               updateRowOrHide('Arreares', data?.Arrear);
               updateRowOrHide('LeaveEncash', data?.LeaveEncash);
               updateRowOrHide('Car_Allowance', data?.Car_Allowance);
               updateRowOrHide('Incentive', data?.INCENTIVE_Value);
               updateRowOrHide('VarRemburmnt', data?.VAR_ALL_Value);
               updateRowOrHide('VariableAdjustment', data?.VariableAdjustment);
               updateRowOrHide('CCA', data?.CCA);
               updateRowOrHide('RA', data?.RA);
               updateRowOrHide('Arr_Basic', data?.Arr_Basic);
               updateRowOrHide('Arr_Hra', data?.Arr_Hra);
               updateRowOrHide('Arr_Spl', data?.Arr_Spl);
               updateRowOrHide('Arr_Conv', data?.Arr_Conv);
               updateRowOrHide('YCea', data?.CHILD_EDU_ALL_Value);
               updateRowOrHide('YMr', data?.MED_REM_Value);
               updateRowOrHide('YLta', data?.LTA_Value);
               updateRowOrHide('Car_Allowance_Arr', data?.Car_Allowance_Arr);
               updateRowOrHide('Arr_LvEnCash', data?.Arr_LvEnCash);
               updateRowOrHide('Arr_Bonus', data?.Arr_Bonus);
               updateRowOrHide('Arr_LTARemb', data?.Arr_LTARemb);
               updateRowOrHide('Arr_RA', data?.Arr_RA);
               updateRowOrHide('Arr_PP', data?.Arr_PP);
               updateRowOrHide('Bonus_Adjustment', data?.Bonus_Adjustment);
               updateRowOrHide('PP_Inc', data?.PP_Inc);
               updateRowOrHide('NPS', data?.NPS);
   
   
               // Deduction Fields
               updateRowOrHide('Tot_Pf_Employee', data?.PF_Employee_Contri_Value);
               updateRowOrHide('NPS_Value', data?.NPS_Value);
               updateRowOrHide('TDS', data?.TDS_Value);
               updateRowOrHide('ESCI_Employee', data?.ESCI);
               updateRowOrHide('Arr_Pf', data?.Arr_Pf);
               updateRowOrHide('Arr_Esic', data?.Arr_Esic);
               updateRowOrHide('VolContrib', data?.VolContrib);
               updateRowOrHide('DeductAdjmt', data?.DeductAdjmt);
               updateRowOrHide('RecSplAllow', data?.RecSplAllow);
   
   
   
           // Open the modal
           var myModal = new bootstrap.Modal(document.getElementById('ctcModal'), {
               keyboard: false
           });
           myModal.show();
       })
       .catch(error => {
           console.error('Error fetching CTC data:', error);
       });
   }
   
   function toggleLoader() {
   document.getElementById('loader').style.display = 'block'; // Show the loader
   }
   
   // Optional: If you want to hide the loader after the page has loaded, 
   // you can use the following code.
   window.addEventListener('load', function() {
   document.getElementById('loader').style.display = 'none'; // Hide the loader after page load
   });
   // $(document).ready(function() {
   //     $('#eligibilityTable').DataTable({
   //         "paging": true,  // Enable pagination
   //         "searching": true,  // Enable search functionality
   //         "lengthChange": true,  // Enable length change (number of rows per page)
   //         "pageLength": 5,  // Number of rows to display per page
   //         "ordering": false     // Disable sorting
   
   //     });
   // });

</script>
</script>
<script src="{{ asset('../js/dynamicjs/teameligibility.js/') }}" defer></script>
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