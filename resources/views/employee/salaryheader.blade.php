<div class="row">
    <!-- Salary Card -->
  
    <div class="col-" style="width:170px;">
        <a title="Salary" href="{{ route('salary') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('salary') ? 'active' : '' }}" style="border-radius: 8px 8px 0px 0px;">
            <div class="p-2 card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width: 30px; margin-right: 10px;" src="./images/icons/salary-icon.png" alt="Salary Icon">
                    <h5 class="ad-title mb-0">Salary</h5>
                </div>
            </div>
        </a>
    </div>
    @php
        $EligibilityMenu = $essMenus->firstWhere('name', 'Salary_Eligibility_block');
        $CTCMenu = $essMenus->firstWhere('name', 'Salary_Ctc_Block');

    @endphp

     @if ($EligibilityMenu && $EligibilityMenu->is_visible)
            
    <!-- Eligibility Card -->
    <div class="col-" style="width:170px;">
        <a title="Eligibility" href="{{ route('eligibility') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('eligibility') ? 'active' : '' }}" style="border-radius: 8px 8px 0px 0px;">
            <div class="p-2 card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                    <h5 class="ad-title mb-0">Eligibility</h5>
                </div>
            </div>
        </a>
    </div>
    @else
    @endif

    @if ($CTCMenu && $CTCMenu->is_visible)
    <!-- CTC Card -->
    <div class="col-" style="width:170px;">
        <a title="CTC" href="{{ route('ctc') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('ctc') ? 'active' : '' }}" style="border-radius: 8px 8px 0px 0px;">
            <div class="p-2 card-body align-items-center text-center border-bottom-d ">
                <div class="icon-info-text-n d-flex align-items-center justify-content-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/ctc-icon.png" alt="CTC Icon">
                    <h5 class="ad-title mb-0">CTC</h5>
                </div>
            </div>
        </a>
    </div>
    @else
    @endif

    <!-- Annual Salary Card -->
    <div class="col-" style="width:170px;">
        <a title="Annual Salary" href="{{ route('annualsalary') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('annualsalary') ? 'active' : '' }}" style="border-radius: 8px 8px 0px 0px;">
            <div class="p-2 card-body align-items-center text-center border-bottom-d ">
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
    <div class="col-" style="width:170px;">
        <a title="Taxation" href="{{ route('investment') }}" 
           class="card cutm-top-menu ad-info-card- text-decoration-none {{ request()->routeIs('investment') ? 'active' : '' }}" style="border-radius: 8px 8px 0px 0px;">
            <div class="p-2 card-body align-items-center text-center border-bottom-d">
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
    border-bottom: 3px solid #427784;
}

/* Hover effect to indicate that the card can be clicked */
.cutm-top-menu:hover {
    background-color: #f0f0f0;
}

</style>