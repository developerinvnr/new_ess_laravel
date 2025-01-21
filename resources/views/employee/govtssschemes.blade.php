@include('employee.header')


<body class="mini-sidebar">
	<div class="loader" style="display: none;">
	  <div class="spinner" style="display: none;">
		<img src="./SplashDash_files/loader.gif" alt="">
	  </div> 
	</div>
    <!-- Main Body -->
    <div class="page-wrapper">
    <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                              
                            </div>
                        </div>
                    </div>
                </div>
                    <style>
                    .form-head{font-size: 18px;
                        color: #e36418;
                        margin-bottom: 10px;
                        text-align: center;}
                    .information-head{
                        text-align: center;
                        font-size: 15px;
                        font-weight: 600;
                    }
                    .govtschemesection p{
                        margin-bottom: 12px;
                        font-size: 13px;
                        font-weight: 400;
                    }
                    .govtschemesection ol li{
                        margin-bottom: 12px;
                        font-size: 13px;
                        font-weight: 400;
                        text-align: justify;
                    }
                    .govtschemeform label{
                        margin-top: 0px;
                        float: left;
                        margin-left: 12px;
                        width: 95%;
                        font-weight: 500;
                    }
                    .govtschemeform input{
                        height: 16px;
                        float: left;
                    }
                    </style>
                <!-- Revanue Status Start -->
                <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    
                    <div class="card">
                        <div class="card-header">
                            <h4>Government Social Security Schemes : Pradhan Mantri Jan Suraksha Yojna.</h4>
                        </div>
                        <div class="card-body table-responsive">
                            <h5 class="form-head">Have you opted for these Government Social Security Schemes yet? (Information is gathered for statistical purpose)<br>क्या आपने सामाजिक सुरक्षा योजनओं का चयन किया हैं ?</h5>
                            <h5 class="information-head">Information gathered is for Statistical use only.<br>
                            यहां एकत्र की गई जानकारी केवल सांख्यिकीय डेटा उपयोग के लिए है|</h5>

                            <form class="form-group" method="POST" action="{{ route('opinion.submit') }}">
                                @csrf
                                <div class="row mt-5">
                                    <div class="col-md-6 govtschemeform">
                                        <label style="width:100%;margin-left:0px;"><b>Select the category you belong to</b></label><br>
                                        <input type="radio" id="General" name="Cast" value="General">
                                        <label for="General">General</label><br>
                                        <input type="radio" id="OBC" name="Cast" value="OBC">
                                        <label for="OBC">OBC</label><br>
                                        <input type="radio" id="SC" name="Cast" value="SC">
                                        <label for="SC">SC</label><br>
                                        <input type="radio" id="ST" name="Cast" value="ST">
                                        <label for="ST">ST</label><br>
                                        <input type="radio" id="anyother" name="Cast" value="Any Other">
                                        <label for="anyother">Any Other</label><br>
                                        <textarea class="form-control" name="CastOther" placeholder="Specify if Any Other"></textarea>
                                    </div>
                                    <div class="col-md-6 govtschemeform">
                                        <div class="form-group">
                                            <label style="width:100%;margin-left:0px;"><b>Please tick the Social Security Schemes opted by you. (Check below for Schemes details) <br>कृपया आपके द्वारा चुने गए सोशल सिक्योरिटी स्कीम पर निशान लगाएं। (योजनाओं के विवरण के लिए नीचे देखें)</b></label><br>
                                            <input type="checkbox" name="Scheme1" value="APY">
                                            <label class="warning">Atal Pension Yojna (APY)</label><br>
                                            <input type="checkbox" name="Scheme2" value="PMJJBY">
                                            <label class="warning">Pradhan Mantri Jeevan Jyoti Bima Yojna (PMJJBY)</label><br>
                                            <input type="checkbox" name="Scheme3" value="PMSBY">
                                            <label class="warning">Pradhan Mantri Suraksha Bima Yojna (PMSBY)</label><br>
                                            <input type="checkbox" name="Scheme4" value="NDS">
                                            <label class="warning">Not opted for above Schemes</label><br>
                                        </div>
                                        <div class="form-group mt-3 mb-0">
                                            <button class="btn btn-primary mt-4" type="reset">Reset</button>
                                            <button class="btn btn-success mt-4" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="mfh-machine-profile">
                                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" id="myTab1" role="tablist" style="background-color:#c5d9db !important ;border-radius: 10px 10px 0px 0px;">
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link active" id="APY-tab21"
                                            data-bs-toggle="tab" href="#APYTab" role="tab"
                                            aria-controls="APYTab" aria-selected="false">Atal Pension Yojana (APY)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="PMJJBY-tab21"
                                            data-bs-toggle="tab" href="#PMJJBYTab" role="tab"
                                            aria-controls="PMJJBYTab" aria-selected="false">Pradhan Mantri Jeevan Jyoti Bima Yojana (PMJJBY)</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="color: #0e0e0e;" class="nav-link" id="PMSBY-tab21"
                                            data-bs-toggle="tab" href="#PMSBYTab" role="tab" aria-controls="PMSBYTab"
                                            aria-selected="false">Pradhan Mantri Suraksha Bima Yojana (PMSBY)</a>
                                    </li>
                                </ul>
                                <div class="tab-content ad-content2 govtschemesection" id="myTabContent2">
                                    <div class="tab-pane fade active show" id="APYTab" role="tabpanel">
                                        <ol>
                                        <li>Atal Pension Yojana (APY) is open to all bank account holders. The Central Government would also co-contribute 50% of the total contribution or Rs. 1000 per annum, whichever is lower, to each eligible subscriber, for a period of 5 years, i.e., from Financial Year 2015-16 to 2019-20, who join the APY before 31st December, 2015, and who are not members of any statutory social security scheme and who are not income tax payers. Therefore, APY will be focussed on all citizens in the unorganised sector. </li>
                     
                                            <li>Under APY, the monthly pension would be available to the subscriber, and after him to his spouse and after their death, the pension corpus, as accumulated at age 60 of the subscriber, would be returned to the nominee of the subscriber. </li>
                     
                                                <li>Under the APY, the subscribers would receive the fixed minimum pension of Rs. 1000 per month, Rs. 2000 per month, Rs. 3000 per month, Rs. 4000 per month, Rs. 5000 per month, at the age of 60 years, depending on their contributions, which itself would be based on the age of joining the APY. Therefore, the benefit of minimum pension would be guaranteed by the Government. However, if higher investment returns are received on the contributions of subscribers of APY, higher pension would be paid to the subscribers.</li>
                     
                                                    <li>A subscriber joining the scheme of Rs. 1,000 monthly pension at the age of 18 years would be required to contribute Rs. 42 per month. However, if he joins at age 40, he has to contribute Rs. 291 per month. Similarly, a subscriber joining the scheme of Rs. 5,000 monthly pension at the age of 18 years would be required to contribute Rs. 210 per month. However, if he joins at age 40, he has to contribute Rs. 1,454 per month. Therefore, it is better to join early in the Scheme. The contribution levels, the age of entry and the pension amounts are available in a table given in frequently asked questions (FAQs) on APY, which is available on www.jansuraksha.gov.in.</li>
                     
                                                        <li>The minimum age of joining APY is 18 years and maximum age is 40 years. Therefore, minimum period of contribution by any subscriber under APY would be 20 years or more.</li>
                                                        <ol>
                      <img src="images/About-APY-2.jpg" />  
                                    </div>
                                    <div class="tab-pane fade" id="PMJJBYTab" role="tabpanel">
                                        <ol>
                                        <li>Government through the Budget Speech announced three ambitious Social Security Schemes pertaining to the Insurance and Pension Sectors, namely Pradhan MantriJeevanJyotiBimaYojana (PMJJBY), Pradhan Mantri Suraksha BimaYojana (PMSBY)and an the Atal Pension Yojana (APY) to move towards creating a universal social security system, targeted especially for the poor and the under-privileged. Hon’ble Prime Minister launched PMJJBY and PMSBY schemes nationally in Kolkata on 9th May, 2015.</li>

                                           <li>The Pradhan MantriJeevanJyotiBimaYojana (PMJJBY) is a one year life insurance scheme, renewable from year to year, offering coverage for death due to any reason and is available to people in the age group of 18 to 50 years( life cover upto age 55) having a savings bank account who give their consent to join and enable auto-debit. The risk cover on the lives of the enrolled persons has commenced from 1st June 2015.</li>
                                            
                                           <li>Under PMJJBY scheme, life cover of Rs. 2 lakhs is available for a one year period stretching from 1st June to 31st May at a premium of Rs.330/- per annum per member and is renewable every year. It is offered / administered through LIC and other Indian private Life Insurance companies. For enrolment banks have tied up with insurance companies. Participating Bank is the Master policy holder. </li>
                                            <li>The assurance on the life of the member shall terminate on any of the following events and no benefit will become payable there under:<br>
                                             1) On attaining age 55 years (age near birth day) subject to annual renewal up to that date (entry, however, will not be possible beyond the age of 50 years).<br>
                                             2) Closure of account with the Bank or insufficiency of balance to keep the insurance in force.<br>
                                             3) A person can join PMJJBY with one Insurance company with one bank account only.</li>
                                            
                                             <li>Individuals who exit the scheme at any point may re-join the scheme in future years by paying the annual premium and submitting a self-declaration of good health. Initial enrolment period in the scheme was from 1st May to 31st May ‘2015, which has now been extended up to 31st Aug’ 2015, by this date eligible persons can join the scheme without giving self-certification of good health, even though eligible persons can join the scheme on any date by paying the premium for full year. In case of claim the nominees/heirs of the insured person have to contact respective bank branch where the insured person was having bank account. A death certificate and simple claim form is required to submit and the claim amount will be transferred to nominees account.</li>
                                             </ol>
                                    </div>
                                    <div class="tab-pane fade" id="PMSBYTab" role="tabpanel">
                                        <ol>
                                        <li>Government through the Budget Speech 2015 announced three ambitious Social Security Schemes pertaining to the Insurance and Pension Sectors, namely Pradhan Mantri Jeevan Jyoti Bima Yojana (PMJJBY), Pradhan Mantri Suraksha Bima Yojana (PMSBY) and an the Atal Pension Yojana (APY) to move towards creating a universal social security system, targeted especially for the poor and the under-privileged. Hon’ble Prime Minister will be launched these schemes nationally in Kolkata on 9th May, 2015.</p>

                                        <li>In light of the fact that a large proportion of the population have no accidental insurance cover, the Pradhan Mantri Suraksha Bima Yojana (PMJJBY) is aimed at covering the uncovered population at an highly affordable premium of just Rs.12 per year. The Scheme will be available to people in the age group 18 to 70 years with a savings bank account who give their consent to join and enable auto-debit on or before 31st May for the coverage period 1st June to 31st May on an annual renewal basis.</li>
                                            
                                        <li>Under the said scheme, risk coverage available will be Rs. 2 lakh for accidental death and permanent total disability and Rs. 1 lakh for permanent partial disability, for a one year period stretching from 1st June to 31st May. It is offered by Public Sector General Insurance Companies or any other General Insurance Company who are willing to offer the product on similar terms with necessary approvals and tie up with banks for this purpose. Participating Bank will be the Master policy holder on behalf of the participating subscribers. It will be the responsibility of the participating bank to recover the appropriate annual premium in one instalment, as per the option, from the account holders on or before the due date through ‘auto-debit’ process and transfer the amount due to the insurance company.</li>
                                            
                                        <li>Individuals who exit the scheme at any point may re-join the scheme in future years by paying the annual premium, subject to conditions. Further, in order to assure a hassle free claim settlement experience for the claimants a simple and subscriber friendly administration & claim settlement process has been put in place.</li>
                                            
                                        <li>To ensure that the benefits of this scheme is brought to every uninsured individual, who holds a bank account, wide publicity was given for this social security measure through electronic media, radio, posters, newspapers advertisements etc. Enrollment forms were widely distributed. Highly publicised Enrollment camps were conducted by Banks, and Insurance Companies, mobilising the entire net work of SLBC Co ordinators, state and district level nodal officers, agents and banking correspondents, thereby fully utilising the reach of these channels, for attracting large scale enrolment in the scheme. Between the date of commencement of enrolment on 01st May till the date of launch of the scheme by the PM on 9th May, 4.42 Crore subscribers were enrolled in the PMJJBY scheme.</li>
                                            
                                        <li>The simplified procedures and the documentary requirements and the procedures to be followed in case of a claim under the policy has been widely publicised through posters and advertisements at every location and point of contact which a claimant is likely to get in touch in case of an accident resulting in a claim under the scheme. An IT enabled, web based system is in the process of being established to keep the claimants informed seamlessly about the progress and status of the claim, till it’s settlement.</li>
                                            
                                        <li>Claim settlement will be made to the bank account of the insured or his nominee in case of death of the account holder.</li>
                                            
                                        <li>The enrolment drive is continuing without loss of momentum till date. As on 31st May, that is, on the eve of commencement date of the policy, the number enrolled under PMSBY scheme had reached 7.29 Crores.</li>
                                            
                                        <li>Immediately after the close of the first phase of enrolments, banks have started the process of auto debit of premium in the accounts of the enrolees and remittance of premium to the insurers. So far premium has been debited to around 65% of the accounts.</li>
                                            
                                        <li>The enrollment is open till 31st August and the drive is continuing. Till 18th June 2015 the number of enrolled under PMSBY stands at 7.68 Crore.</li>
                                            
                                        <li>The scheme is expected to serve the goal of financial inclusion by achieving penetration of insurance down to the weaker sections of the society, ensuring their or their family’s financial security, which otherwise gets pulled to the ground in case of any unexpected and unfortunate accident.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            
                        <p style="border-top:1px solid #ddd;padding-top:10px;margin-top:15px;"><b>Note</b> : <b>For more details click to <a target="_blank" href="http://www.jansuraksha.gov.in">http://www.jansuraksha.gov.in</a></b></p>
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
<script src="{{ asset('../js/dynamicjs/team.js/') }}" defer></script>