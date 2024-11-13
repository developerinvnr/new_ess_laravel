@include('employee.head')
@include('employee.header');
@include('employee.sidebar');

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
        <!-- Sidebar Start -->
        @include('employee.sidebar');
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
                                        <a href="#"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Investment Ddeclaration</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
				<div class="row">
                   
                    <div class="col ">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width: 50px;" src="./images/icons/salary-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">Salary</h5>
                                    <a href="{{route('salary')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Card-->
                    <div class="col ">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/eligibility-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">Eligibility</h5>
                                    <a href="{{route('eligibility')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					
                    <!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/ctc-icon.png">
                                    <h5 class="ad-title mt-3 mb-3">CTC</h5>
                                    <a href="{{route('ctc')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>

					<!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/annual-salary.png">
                                    <h5 class="ad-title mt-3 mb-3">Annual Salary</h5>
                                    <a href="#annualsalary" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/invetment.png">
                                    <h5 class="ad-title mt-3 mb-3">Invt. Declaration</h5>
                                    <a href="{{route('investment')}}" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<!-- Start Card-->
                    <div class="col">
                        <div class="card ad-info-card-">
                            <div class="card-body align-items-center text-center border-bottom-d" style="min-height:182px;">
                                <div class="icon-info-text-n">
                                    <img style="width:50px;" src="./images/icons/invetment-submit.png">
                                    <h5 class="ad-title mt-3 mb-3">Invt. Submission</h5>
                                    <a href="investment-submission.html" class="btn-outline secondary-outline mt-2 mr-2 sm-btn" fdprocessedid="msm7d">View More</a>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="card ad-info-card-">
                            <div class="card-header">
                                <h4 class="has-btn">Ledger</h4>
                            </div>
                            <div class="card-body dd-flex align-items-center border-bottom-d" style="height: 142px;">
                                <table class="table">
                                    <tbody> 	
                                    <tr>
                                    <td >1.</td>
                                    <td ><b>Ledger 2023-24</b></td>
                                    <td><a><i style="font-size:15px;" class="fas fa-download"></i></a></td>
                                    </tr>       
                                </tbody></table>
                            </div>
                        </div>
                    </div>
				</div>
                
                <!-- Revanue Status Start -->
                <div class="row">     
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10" >
                        <div class="card chart-card ">
                            <div class="card-header" id="attendance">
                                <h4 class="text-center">Investment Declaration Form 2023-2024</h4>
                            </div>
                            <div class="card-body" style="padding-top:0px;">
                                <div class="mfh-machine-profile">
                                <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="oldregime-tab1" data-bs-toggle="tab" href="#oldregime" role="tab" aria-controls="OldRegime" aria-selected="true">Old Regime</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="newregime-tab20" data-bs-toggle="tab" href="#newregime" role="tab" aria-controls="newregime" aria-selected="false">New Regime</a>
                                    </li>
                                </ul>
                                <div class="tab-content splash-content2 mt-3" id="myTabContent2">
                                    <div class="tab-pane fade active table-responsive show" id="oldregime" role="tabpanel">
                                        <ul class="user-details">
                                            <li>Employee ID: 1254</li>
                                            <li>Employee Name: Rohit Kumar</li>
                                            <li>PAN Number: ADT12548RH</li>
                                            <li>Company Name: VNR SEEDS PVT. LTD.</li>
                                        </ul>
                                        <br>
                                        <p><b>Please remember the following points while filling up the form</b></p>
<ol style="color: #686464;">
    <li>Do not forget to mention you Employee Id , Name & Pan card .</li>
    <li>Only Submission Amount needs to be filled. Do not change the figures mentioned in Max. limit Column.</li>
    <li> You are requested to submit the required proofs up to last date of submission, failing which will be assumed that the employee does not have any Tax </li>
    <li>Saving and income other than salary, and the Income Tax will be recomputed and tax will be deducted accordingly.</li>
</ol>
<p><b>(To be used to declare investment for income Tax that will be made during the period )</b></p><br>
<p><b>Deduction Under Section 10</b></p>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Item</th>
                                                    <th>Particulars</th>
                                                    <th style="width: 7%;">Max. Limit</th>
                                                    <th style="width: 14%;">Declared Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>House Rent Sec 10(13A)</td>
                                                    <td>I am staying in a house and I agree to submit rent receipts when required. The Rent paid is (Rs._______ Per Month) & the house is located in Non-Metro</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td>LTA Sec 10(5)</td>
                                                    <td>I will provide the tickets/ Travels bills in original as per(one basic annually) the LTA policy or else the company can consider amount as taxable.</td>
                                                    <td><b>16000/-</b> <input style="float:right;height: 15px;" type="checkbox"></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td>CEA Sec 10(14)</td>
                                                    <td>I will provide the copy of tuition fees receipt as per CEA policy or else the company can consider amount as taxable.(Rs100/- per month per child up to max of two children)</td>
                                                    <td><b>2400/-</b> <br>Child-1 <input style="float:right;height: 15px;" type="checkbox"> Child-2 <input style="float:right;height: 15px;" type="checkbox"></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p style="color: #686464;">** If you have opted for the medical reimbursements ( being Medical expenses part of your CTC)</p>
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Item</th>
                                                    <th>Particulars</th>
                                                    <th style="width: 7%;">Max. Limit</th>
                                                    <th style="width: 14%;">Declared Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Deductions Under Chapter VI A</td>
                                                    <td>Sec.80D - Medical Insurance Premium (If the policy covers a senior Citizen then additional deduction of Rs.5000/- is available & deduction on account of expenditure on preventive Health Check-Up (for Self, Spouse, Dependant Children & Parents )Shall not exceed in the aggregate Rs 5000/-.)</td>
                                                    <td><b>25000/-</b></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>"Sec. 80DD - Medical treatment/insurance of Handicapped Dependant A higher deduction of Rs. 100,000 is available, where such dependent is with severe disability of > 80%"</td>
                                                    <td><b>50000/-</b></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>"Sec 80DDB - Medical treatment (specified diseases only) (medical treatment in respect of a senior Citizen then additional deduction of Rs.20,000/- is available)"</td>
                                                    <td><b>40000/-</b></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Sec 80E - Repayment of Loan for higher education (only interest)</td>
                                                    <td>-</td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Sec 80U - Handicapped</td>
                                                    <td><b>50000/-</b></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Item</th>
                                                    <th>Particulars</th>
                                                    <th style="width: 7%;">Max. Limit</th>
                                                    <th style="width: 14%;">Declared Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Deduction Under Section 80C</td>
                                                    <td>Sec 80CCC - Contribution to Pension Fund (Jeevan Suraksha)</td>
                                                    <td><b>25000/-</b></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Life Insurance Premium</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Deferred Annuity</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Public Provident Fund</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Time Deposit in Post Office / Bank for 5 year & above</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>ULIP of UTI/LIC</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Principal Loan (Housing Loan) Repayment</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Mutual Funds</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Investment in infrastructure Bonds</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Children- Tuitions Fee restricted to max. of 2 children</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Deposit in NHB</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Deposit In NSC</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Sukanya Samriddhi</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td>Others (please specify) Employee Provident Fund</td>
                                                    <td></td>
                                                    <td><input type="text"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><b>Declaration:</b></p>
                                            <ol><li>I hereby declare that the information given above is correct and true in all respects.</li>
                                            <li>I also undertake to indemnify the company for any loss/liability that may arise in the event of the above information being incorrect.</li>
                                            </ol>
                                        <div class="row">
                                            <div class="col-md-12 mt-4 mb-3">   
                                            <div class="float-start">
                                                <b>Date:</b>  15 Feb 2024<br> <br><b>Place:</b>  Raipur
                                            </div>
                                            <div class="float-end mt-3">
                                                <b>Signature</b>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="newregime" role="tabpanel">
                                        <ul class="user-details">
                                            <li>Employee ID: 1254</li>
                                            <li>Employee Name: Rohit Kumar</li>
                                            <li>PAN Number: ADT12548RH</li>
                                            <li>Company Name: VNR SEEDS PVT. LTD.</li>
                                        </ul>
                                        <br>
                                        <p><b>Please remember the following points while filling up the form</b></p>
<ol style="color: #686464;">
    <li>Do not forget to mention you Employee Id , Name & Pan card .</li>
    <li>Only Submission Amount needs to be filled. Do not change the figures mentioned in Max. limit Column.</li>
    <li> You are requested to submit the required proofs up to last date of submission, failing which will be assumed that the employee does not have any Tax </li>
    <li>Saving and income other than salary, and the Income Tax will be recomputed and tax will be deducted accordingly.</li>
</ol>
<p><b>(To be used to declare investment for income Tax that will be made during the period )</b></p><br>
<p><b>Deduction Under Section 10</b></p>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10%;">Item</th>
                                                    <th>Particulars</th>
                                                    <th style="width: 7%;">Max. Limit</th>
                                                    <th style="width: 14%;">Declared Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Sec. 80CCD(2)</td>
                                                    <td>Corporate NPS Scheme</td>
                                                    <td>10% Of Basic Salary</td>
                                                    <td><input type="text"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p><b>Declaration:</b></p>
                                            <ol><li>I hereby declare that the information given above is correct and true in all respects.</li>
                                            <li>I also undertake to indemnify the company for any loss/liability that may arise in the event of the above information being incorrect.</li>
                                            </ol>
                                        <div class="row">
                                            <div class="col-md-12 mt-4 mb-3">   
                                            <div class="float-start">
                                                <b>Date:</b>  15 Feb 2024<br> <br><b>Place:</b>  Raipur
                                            </div>
                                            <div class="float-end mt-3">
                                                <b>Signature</b>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
				<div class="ad-footer-btm">
					<p><a href="">Terms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
				</div>
            </div>
                
				<div class="ad-footer-btm">
					<p><a href="">Terms of use </a> | <a href="">Privacy Policy</a> Copyright 2023 © VNR Seeds Pvt. Ltd India All Rights Reserved.</p>
				</div>
            </div>
        </div>
    </div>
    
    @include('employee.footer');