@include('employee.header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    td:not(.fw-bold) {
        color: #900C3F;
    }
</style>

<body class="mini-sidebar">
    @include('employee.sidebar')

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
                                        <a href="{{ route('dashboard') }}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Vehicle Policy Migration Calculator</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <!-- Section A: General Information -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-info-circle-fill me-2"></i>A. GENERAL INFORMATION
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-secondary" style="width:30%">EMP NAME</td>
                                            <td class="" style="width:20%">{{ $details->Name }}</td>
                                            <td class="fw-bold text-secondary" style="width:30%">DEPARTMENT</td>
                                            <td class="" style="width:20%">{{ $details->Department }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold text-secondary">GRADE</td>
                                            <td>{{ $details->Grade }}</td>
                                            <td class="fw-bold text-secondary">POLICY NAME</td>
                                            <td>{{ $details->PolicyName }}</td>
                                        </tr>


                                        <!-- Section B: Policy Summary -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-file-text-fill me-2"></i>B. POLICY SUMMARY
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="2">Existing Policy</th>
                                            <th class="text-center" colspan="2">Proposed Policy</th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Eligible Vehicle Value</td>
                                            <td class="text-right">₹ {{ $details->ExistingVehicleValue }}</td>
                                            <td class="fw-bold">Eligible Vehicle Value</td>
                                            <td class="text-right">₹ {{ $details->ProposedVehicleValue }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Vehicle Life</td>
                                            <td class="text-right">{{ $details->Policy }}</td>
                                            <td class="fw-bold">Vehicle Life</td>
                                            <td class="text-right">{{ $details->Vehicle_Life_New }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Monthly Allowed KM</td>
                                            <td class="text-right">{{ $details->Existing_Monthly_KM }}</td>
                                            <td class="fw-bold">Monthly Allowed KM</td>
                                            <td class="text-right">{{ $details->Proposed_Monthly_KM }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Yearly Allowed KM</td>
                                            <td class="text-right">{{ $details->Existing_Yearly_KM }}</td>
                                            <td class="fw-bold">Yearly Allowed KM</td>
                                            <td class="text-right">{{ $details->Proposed_Yearly_KM }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Policy Reimbursement Rate</td>
                                            <td class="text-right">₹ {{ $details->Policy_Rate_Existing }}</td>
                                            <td class="fw-bold">Policy Reimbursement Rate</td>
                                            <td class="text-right">₹ {{ $details->Policy_Rate_New }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Reduced Reimbursement Rate</td>
                                            <td class="text-right">₹ {{ $details->Reduced_Rate_Existing }}</td>
                                            <td class="fw-bold">Reduced Reimbursement Rate</td>
                                            <td class="text-right">{{ $details->Reduced_Rate_New }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold"></td>
                                            <td class="text-right"></td>
                                            <td class="fw-bold">Monthly Car Allowance (Part of CTC-NI)</td>
                                            <td class="text-right">₹ {{ $details->Monthly_Car_Allowance }}</td>
                                        </tr>
                                        <!-- ... Similar formatting for other policy details ... -->

                                        <!-- Section C: Impact Analysis -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-graph-up-arrow me-2"></i>C. Impact Old Vs New (Yearly)
                                                Based on Averaged KM Apr-Jan
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" colspan="2">Existing Policy</th>
                                            <th class="text-center" colspan="2">Proposed Policy</th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                            <td class="fw-bold text-center">Parameters</td>
                                            <td class="fw-bold text-center">Value</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">KM Claimed Upto 31/Jan/25</td>
                                            <td class="text-right">₹ {{ $details->AlreadyRunAfterApril24 }}</td>
                                            <td class="fw-bold">KM Claimed Upto 31/Jan/25</td>
                                            <td class="text-right">₹ {{ $details->AlreadyRunAfterApril24 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Average KMs for 12 Months</td>
                                            <td class="text-right">₹ {{ $details->Avg_Estimated_Running }}</td>
                                            <td class="fw-bold">Average KMs for 12 Months</td>
                                            <td class="text-right">₹ {{ $details->Avg_Estimated_Running }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Policy Reimbursement Rate Claim</td>
                                            <td class="text-right">₹
                                                {{ $details->Amount_to_be_Claimed_in_Existing_Policy }}</td>
                                            <td class="fw-bold">Policy Reimbursement Rate Claim</td>
                                            <td class="text-right">₹
                                                {{ $details->Amount_to_be_Claimed_in_New_Policy }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Reduced Reimbursement Rate Claim</td>
                                            <td class="text-right">₹
                                                {{ $details->Amount_to_be_Claimed_in_Existing_Policy_Reduced_Rate }}
                                            </td>
                                            <td class="fw-bold">Reduced Reimbursement Rate Claim</td>
                                            <td class="text-right">₹
                                                {{ $details->Amount_to_be_Claimed_in_New_Policy_Reduced_Rate }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold"></td>
                                            <td class="text-right"></td>
                                            <td class="fw-bold">Fixed Component (As Per Grade)</td>
                                            <td class="text-right">₹
                                                {{ $details->Yearly_Car_Allowance_in_New_Policy }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Total</td>
                                            <td class="text-right">₹
                                                {{ $details->Total_amount_to_be_Claimed_in_Existing_Policy }}</td>
                                            <td class="fw-bold">Total</td>
                                            <td class="text-right">₹
                                                {{ $details->Total_Yearly_Amount_to_be_Claimed_in_New_Policy }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-center" colspan="3">Impact</td>
                                            <td class="text-right text-success fw-bold">₹
                                                {{ $details->Amt_Old_VS_New_Yearly }}</td>

                                        </tr>
                                        <!-- Section D: Migration Clause -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-arrow-left-right me-2"></i>D. MIGRATION CLAUSE
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                To facilitate a smooth transition from the existing policy to the new
                                                policy, including for those whose vehicle value is lower than the
                                                eligible value in the proposed policy, migration will be based on a
                                                repayment of fixed component calculated over the remaining life of the
                                                vehicle
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Eligible Vehicle Value (a)</td>
                                            <td class="text-right">₹ {{ $details->ProposedVehicleValue }}</td>
                                            <td class="fw-bold">Actual Vehicle Value (b)</td>
                                            <td class="text-right">₹ {{ $details->ActualVehicleValue }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Diff in Vehicle Value (c)=(a)-(b)</td>
                                            <td class="text-right">₹
                                                {{ $details->Vechicle_Value_Diff_Proposed_Vs_Actual }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Migration Impact</td>
                                            <td colspan="3">Migration Based on Fixed Component Recovery over
                                                Remaining Life of Vehicle (Refer Below) </td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Monthly Fixed Component for Eligible Vehicle Value (d)
                                            </td>
                                            <td class="text-right">₹ {{ $details->Monthly_Claim_under_new_Fixed }}
                                            </td>
                                            <td class="fw-bold">Remaining Month as on 01.04.2025 (e)</td>
                                            <td class="text-right"> {{ $details->Remaining_Month }}</td>
                                        </tr>

                                        <tr>
                                            <td class="fw-bold">Calculated Monthly Fixed component For Actual Vehicle
                                                value (f)=((d)/(a)*b)</td>
                                            <td class="text-right">₹
                                                {{ $details->Calculated_Monthly_Fixed_Component }}</td>
                                            <td class="fw-bold">Total Reimbursement on remaining life of Vehicle as per
                                                calculated Monthly Fixed Component (g)=(e)*(f)</td>
                                            <td class="text-right">₹ {{ $details->Total_Reimbursement }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-info" colspan="4">Since the monthly fixed
                                                component is reimbursed based on the eligible vehicle value rather than
                                                the actual vehicle value, the remaining period for the monthly fixed
                                                component will be reduced if the actual vehicle value is lower than the
                                                eligible value </td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Adjusted Remaining Months to cover Remaining Fixed
                                                portion of actual vehicle value as per the Month fixed rate of Eligible
                                                vehicle value (h)=(g)/(d)</td>
                                            <td class="text-right">{{ $details->Adjusted_Remaining_Month }}</td>
                                            <td class="fw-bold">Revised Policy validity</td>
                                            <td class="text-right">{{ $details->Adj_Remaining_Life_in_Month }}</td>
                                        </tr>


                                        <!-- Section E: Vehicle Details -->
                                        <tr class="bg-light text-white">
                                            <th colspan="4" class="h5 p-3 text-center">
                                                <i class="bi bi-car-front-fill me-2"></i>E. Employee Current Vehicle
                                                Details (Check & if Updation Required mail to HR with document)
                                            </th>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Utilized KMs as on 01.04.24</td>
                                            <td class="text-right">{{ $details->AlreadyRunBeforeApril24 }}</td>
                                            <td class="fw-bold">Utilized KMs as on 31.01.24</td>
                                            <td class="text-right">{{ $details->AlreadyRunAfterApril24 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Utilized Vehicle Life</td>
                                            <td class="text-right">{{ $details->Claimed_Vehicle_Life }}</td>
                                            <td class="fw-bold">Policy Coverage Till :</td>
                                            <td class="text-right">{{ $details->PolicyCoverageDate }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Model Name :</td>
                                            <td class="text-right">{{ $details->Model_Name }}</td>
                                            <td class="fw-bold">Price :</td>
                                            <td class="text-right">₹ {{ $details->Price }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Purchase Date :</td>
                                            <td class="text-right">{{ $details->Purchase_Date }}</td>
                                            <td class="fw-bold">Fuel Type :</td>
                                            <td class="text-right">{{ $details->Fuel_Type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold">Regis. No :</td>
                                            <td class="text-right">{{ $details->Regis_No }}</td>
                                            <td class="fw-bold">Regis. Date :</td>
                                            <td class="text-right">{{ $details->Regis_Date }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Revanue Status Start -->
                    <div class="row">
                        @include('employee.footerbottom')

                    </div>
                </div>
            </div>
        </div>



        @include('employee.footer');
