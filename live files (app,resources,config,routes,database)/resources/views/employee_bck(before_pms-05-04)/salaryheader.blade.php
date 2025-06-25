<div class="row">
    <!-- Salary Card -->
  
    <div class="col">
        <a href="{{ route('salary') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('salary') ? 'active' : '' }}">
            <div class="card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width: 30px; margin-right: 10px;" src="./images/icons/salary-icon.png" alt="Salary Icon">
                    <h5 class="ad-title mb-0">Salary</h5>
                </div>
            </div>
        </a>
    </div>

    <!-- Eligibility Card -->
    <div class="col">
        <a href="{{ route('eligibility') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('eligibility') ? 'active' : '' }}">
            <div class="card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                    <h5 class="ad-title mb-0">Eligibility</h5>
                </div>
            </div>
        </a>
    </div>

    <!-- CTC Card -->
    <div class="col">
        <a href="{{ route('ctc') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('ctc') ? 'active' : '' }}">
            <div class="card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/ctc-icon.png" alt="CTC Icon">
                    <h5 class="ad-title mb-0">CTC</h5>
                </div>
            </div>
        </a>
    </div>

    <!-- Annual Salary Card -->
    <div class="col">
        <a href="{{ route('annualsalary') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('annualsalary') ? 'active' : '' }}">
            <div class="card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/annual-salary.png" alt="Annual Salary Icon">
                    <h5 class="ad-title mb-0">Annual Salary</h5>
                </div>
            </div>
        </a>
    </div>

    @php
    
    $employeesinvestment = DB::table('hrm_employee_key')
                   ->where('CompanyId', Auth::user()->CompanyId)
                   ->get();
                   if ($employeesinvestment->isNotEmpty()) {
        $investDecl = $employeesinvestment->first()->InvestDecl;
    }    
   @endphp
  @if($investDecl == 'Y')
    <!-- Investment Declaration Card -->
    <div class="col">
        <a href="{{ route('investment') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('investment') ? 'active' : '' }}">
            <div class="card-body align-items-center text-center border-bottom-d">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/invetment.png" alt="Investment Declaration Icon">
                    <h5 class="ad-title mb-0">Taxation</h5>
                </div>
            </div>
        </a>
    </div>
    @endif

    <!-- Investment Submission Card -->
    <!-- <div class="col">
        <a href="{{route('investmentsub')}}" class="card ad-info-card- text-decoration-none">
            <div class="card-body align-items-center text-center border-bottom-d">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/invetment-submit.png" alt="Investment Submission Icon">
                    <h5 class="ad-title mb-0">Inv. Submission</h5>
                </div>
            </div>
        </a>
    </div> -->
</div>


<style>

/* Active state when the card is clicked or default active on page load */
.cutm-top-menu.active {
    background-color: #ccc; /* Gray background when active */
    border-radius: 8px 8px 0px 0px;
}

/* Hover effect to indicate that the card can be clicked */
.cutm-top-menu:hover {
    background-color: #f0f0f0;
}

</style>