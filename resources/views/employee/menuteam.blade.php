<div class="row">
    
<!-- Query Card -->
<div class="col">
    <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
        <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamquery') ? 'active' : '' }}" id="teamass">
            <a title="Query" href="{{ route('teamquery') }}">
                <div class="icon-info-text-n d-flex align-items-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/icon4.png" alt="Query">
                    <h5 class="ad-title mb-0">Query</h5>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Assets Card -->
<div class="col">
    <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
        <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamassets') ? 'active' : '' }}" id="teamque">
            <a title="Assets" href="{{ route('teamassets') }}">
                <div class="icon-info-text-n d-flex align-items-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/icon2.png" alt="Assets">
                    <h5 class="ad-title mb-0">Assets</h5>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Eligibility CTC Card -->
<div class="col">
    <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
        <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teameligibility') ? 'active' : '' }}" id="teamelig">
            <a title="Eligibility CTC" href="{{ route('teameligibility') }}">
                <div class="icon-info-text-n d-flex align-items-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility">
                    <h5 class="ad-title mb-0">Eligibility CTC</h5>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Cost Card -->
<div class="col">
    <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
        <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamcost') ? 'active' : '' }}" id="teamcost">
            <a title="Cost" href="{{ route('teamcost') }}">
                <div class="icon-info-text-n d-flex align-items-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/team-cost.png" alt="Cost">
                    <h5 class="ad-title mb-0">Cost</h5>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Other Cards -->
<div class="col">
    <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
        <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamconfirmation') ? 'active' : '' }}">
            <a title="Confirm" href="{{ route('teamconfirmation') }}">
                <div class="icon-info-text-n d-flex align-items-center">
                    <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Confirm">
                    <h5 class="ad-title mb-0">Confirm<sup>n</sup></h5>
                </div>
            </a>
        </div>
    </div>
</div>

    <!-- LMS Card -->
    <div class="col">
        <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamtrainingsep') ? 'active' : '' }}" id="teamtraining">
                <a title="LMS" href="{{ route('teamtrainingsep') }}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon5.png" alt="LMS">
                        <h5 class="ad-title mb-0">LMS</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Separation/Clearance Card -->
    <div class="col">
        <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamseprationclear') ? 'active' : '' }}" id="teamclear">
                <a title="Clearance" href="{{ route('teamseprationclear') }}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/separation-icon.png" alt="Clearance">
                        <h5 class="ad-title mb-0">Sepr<sup>n</sup>/<br>Clearance</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>


    <!-- Team's Details Card -->
    <div class="col">
        <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('team') ? 'active' : '' }}" id="team">
                <a title="Team's Details" href="{{ route('team') }}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon1.png" alt="Team's Details">
                        <h5 class="ad-title mb-0">Team's Details</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Attendance/Leave Card -->
    <div class="col">
        <div class="card ad-info-card-" style="border-radius: 8px 8px 0px 0px;">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card {{ request()->routeIs('teamleaveatt') ? 'active' : '' }}" id="teamatt">
                <a title="Attendance/Leave" href="{{ route('teamleaveatt') }}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/leave-day.png" alt="Attendance">
                        <h5 class="ad-title mb-0">Att.<br>/Leave</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>

    /* Active state when the card is clicked or default active on page load */
    .menu-card.active {
        background-color: #ccc; /* Gray background when active */
        border-radius: 8px 8px 0px 0px;
        border-bottom: 3px solid #427784;
    }
    
    /* Hover effect to indicate that the card can be clicked */
    .menu-card:hover {
        background-color: #f0f0f0;
    }
    
    </style>
