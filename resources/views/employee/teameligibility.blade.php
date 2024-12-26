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
        <div class="main-content">
            <!-- Page Title Start -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-title-wrapper">
                        <div class="breadcrumb-list">
                            <ul>
                                <li class="breadcrumb-link">
                                    <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
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
                                            <label for="hod-view" class="form-label text-muted mt-1">HOD/Reviewer</label>
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                name="hod_view" 
                                                id="hod-view" 
                                                {{ request()->has('hod_view') ? 'checked' : '' }} 
                                                onchange="this.form.submit();" 
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
                                        <th>Sno.</th>
                                        <th>Name</th>
                                        <th>EC</th>
                                        <th>Designation</th>
                                        <th>Grade</th>
                                        <th colspan="5">CTC</th>
                                        <th colspan="4">Eligibility</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Net</th>
                                        <th>Gross</th>
                                        <!-- <th>Deduction</th> -->
                                        <th>Total</th>
                                        <th>More</th>
                                        <th>DA</th>
                                        <th>Mobile</th>
                                        <th>Vehicle</th>
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
                                            <td style="text-align:left;">{{ $eligibilityData->Fname }} {{ $eligibilityData->Sname }} {{ $eligibilityData->Lname }}</td>
                                            <td  style="text-align:left;">{{ $eligibilityData->EC }}</td>
                                            <td  style="text-align:left;">{{ $eligibilityData->DesigCode }}</td>
                                            <td>{{$eligibilityData->GradeValue}}</td>
                                            <td>{{$eligibilityData->NetSalary}}</td>
                                            <td>{{$eligibilityData->GrossSalary}}</td>
                                            <td>{{$eligibilityData->TotalCTC}}</td>
                                            <td>
                                                <a href="javascript:void(0)"
                                                    onclick="fetchEligibilityData({{ $eligibilityData->EmployeeID }})"
                                                    style="color: #007bff; text-decoration: underline; cursor: pointer;">
                                                    <i class="fas fa-eye"></i> <!-- Font Awesome Eye Icon -->
                                                </a>
                                            </td>

                                            <td>{{ $eligibilityData->DA_Inside_Hq ?? '-' }}</td>
                                            <td>{{ $eligibilityData->Mobile_Exp_Rem ?? '-' }}</td>
                                            <td>{{ $eligibilityData->VehiclePolicy ?? '-' }}</td>

                                            <td>
                                                <a href="javascript:void(0)"
                                                    onclick="fetchCtcData({{ $eligibilityData->EmployeeID }})"
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
    <div class="modal fade" id="eligibilitydetails" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
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
                                        <li>City Category A: <span id="lodgingA"></span>/-</li>
                                        <li>City Category B: <span id="lodgingB"></span>/-</li>
                                        <li>City Category C: <span id="lodgingC"></span>/-</li>
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
                                        <li>DA@HQ: <span id="daHq"></span> /- Per Day</li>
                                        <li>DA Outside HQ: <span id="daOutsideHq"></span> /- Per Day</li>
                                    </ul>
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
                                        <li><strong>2 Wheeler:(Per km)</strong> <span id="twheeler"></span></li>
                                        <li><strong>4 Wheeler:(Per km)</strong> <span id="fwheeler"></span></li>
                                        <li><strong>Mode/Class outside HQ:</strong> <span id="outsideHq"></span></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card chart-card">
                                <div class="card-header eligibility-head-title">
                                    <h4 class="has-btn">Mobile Eligibility</h4>
                                    <p>(Subject to submission of bills)</p>
                                </div>
                                <div class="card-body">
                                    <ul class="eligibility-list">
                                        <li>Handset: <span id="handset"></span></li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Add more sections like Gratuity / Deduction if needed -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-outline secondary-outline mt-2 mr-2 sm-btn"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ctc-->
    <div class="modal fade" id="ctcModal" tabindex="-1" aria-labelledby="ctcModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ctcModalLabel">CTC Details</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Monthly Components -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header">
                                    <h4 class="has-btn">Monthly Components</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center">
                                    <ul class="ctc-section" id="monthly-components">
                                        <li>
                                            <div class="ctc-title">Basic</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="BAS_Value"></b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">HRA</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="HRA_Value">12,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Bonus</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="Bonus1_Value">5,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Special Allowance</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="SpecialAllowance_Value">2,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Gross Monthly Salary</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="Gross_Monthly_Salary">55,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Provident Fund</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="PF_Value">1,500</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Net Monthly
                                                Salary</div>
                                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                    class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="Net_Monthly_Salary">48,500</b></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card chart-card">
                                <div class="card-header">
                                    <h4 class="has-btn">Additional Benefit</h4>
                                </div>
                                <div class="card-body dd-flex align-items-center">
                                    <ul class="ctc-section" id="additional-benefit">
                                        <li>
                                            <div class="ctc-title">Insurance Policy Premium</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="InsurancePremium_Value">3,000</b></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Annual Components -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card chart-card">
                                <div class="card-header ctc-head-title">
                                    <h4 class="has-btn">Annual Components</h4>
                                    <p>(Tax saving components which shall be reimbursed on production of documents)</p>
                                </div>
                                <div class="card-body dd-flex align-items-center">
                                    <ul class="ctc-section" id="annual-components">
                                        <li>
                                            <div class="ctc-title">Leave Travel Allowance</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="LTA_Value">12,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Children Education Allowance</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="ChildEduAllowance_Value">2,400</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Annual
                                                Gross Salary</div>
                                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                    class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="AnnualGrossSalary_Value">660,000</b></div>
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
                                            <div class="ctc-title">Estimated Gratuity</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="Gratuity_Value">50,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Employer's PF Contribution</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="EmployerPF_Value">5,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Insurance Policy Premiums</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="InsurancePolicy_Value">3,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Fixed CTC</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="FixedCTC_Value">720,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title">Performance Pay</div>
                                            <div class="ctc-value"><i class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="PerformancePay_Value">25,000</b></div>
                                        </li>
                                        <li>
                                            <div class="ctc-title" style="font-weight: 600;font-size: 16px;">Total CTC
                                            </div>
                                            <div class="ctc-value" style="font-weight: 600;font-size: 17px;"><i
                                                    class="fas fa-rupee-sign"></i> <b class="ml-2"
                                                    id="TotalCTC_Value">775,000</b></div>
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
                                <li>Performance Pay is an annually paid variable component of CTC, paid in July salary.
                                </li>
                                <li>This amount is indicative of the target variable pay, actual pay-out will vary based
                                    on the performance of Company and Individual.</li>
                                <li>It is linked with Company performance (as per fiscal year) and Individual
                                    Performance (as per appraisal period for minimum 6 months working, pro-rata basis if
                                    < 1 year working).</li>
                                <li>The calculation shall be based on the pre-defined performance measures at both,
                                    Company & Individual level.</li>
                            </ol>
                            <p>For more details refer to the Company’s Performance Pay
                                policy.<br><br><b>Important</b><br>This is a confidential page not to be discussed
                                openly with others. You shall be personally responsible for any leakage of information
                                regarding your compensation.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</body>

@include('employee.footer')
<script>
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

                // Populate the modal with the fetched data
                document.getElementById('lodgingA').innerText = data.Lodging_CategoryA;
                document.getElementById('lodgingB').innerText = data.Lodging_CategoryB;
                document.getElementById('lodgingC').innerText = data.Lodging_CategoryC;

                document.getElementById('daHq').innerText = data.DA_Inside_Hq;
                document.getElementById('daOutsideHq').innerText = data.DA_Outside_Hq;

                document.getElementById('twheeler').innerText = data.Travel_TwoWeeKM;
                document.getElementById('fwheeler').innerText = data.Travel_FourWeeKM;
                document.getElementById('outsideHq').innerText = data.Mode_Travel_Outside_Hq;

                document.getElementById('handset').innerText = data.Mobile_Hand_Elig ? "Eligible" : "Not Eligible";

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
                if (data.error) {
                    alert(data.error); // If there's an error, show an alert
                    return;
                }

                // Populate the modal with the fetched CTC data
                document.getElementById('BAS_Value').innerText = data.BAS_Value || 'N/A';
                document.getElementById('HRA_Value').innerText = data.HRA_Value || 'N/A';
                document.getElementById('Bonus1_Value').innerText = data.BONUS_Value || 'N/A';

                document.getElementById('SpecialAllowance_Value').innerText = data.SpecialAllowance_Value || 'N/A';
                document.getElementById('Gross_Monthly_Salary').innerText = data.Tot_GrossMonth || 'N/A';
                document.getElementById('PF_Value').innerText = data.PF_Employee_Contri_Value || 'N/A';
                document.getElementById('Net_Monthly_Salary').innerText = data.NetMonthSalary_Value || 'N/A';

                // Additional benefits
                document.getElementById('ChildEduAllowance_Value').innerText = data.CHILD_EDU_ALL_Value || 'N/A';

                // Annual Components
                document.getElementById('LTA_Value').innerText = data.LTA_Value || 'N/A';
                document.getElementById('InsurancePremium_Value').innerText = data.INC_Value || 'N/A';

                // Add performance-related details
                document.getElementById('AnnualGrossSalary_Value').innerText = data.Tot_Gross_Annual || 'N/A';

                document.getElementById('Gratuity_Value').innerText = data.GRATUITY_Value || 'N/A';
                document.getElementById('EmployerPF_Value').innerText = data.PF_Employee_Contri_Value || 'N/A';
                document.getElementById('InsurancePolicy_Value').innerText = data.INC_Value || 'N/A';
                document.getElementById('FixedCTC_Value').innerText = data.TotCtc || 'N/A';
                document.getElementById('PerformancePay_Value').innerText = data.PerformancePay_value || 'N/A';
                document.getElementById('TotalCTC_Value').innerText = data.TotCtc || 'N/A';

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
    $(document).ready(function() {
        // Initialize DataTable
        $('#eligibilityTable').DataTable({
            "paging": true,       // Enable pagination
            "ordering": true,     // Enable column sorting
            "info": true,         // Display information about the table
            "lengthChange": false, // Disable length change (optional)
            "searching": false    // Disable the search bar

        });
    });


</script>

</script>
<script src="{{ asset('../js/dynamicjs/teameligibility.js/') }}" defer></script>