<div class="row">
    
<div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamass">
                <a href="{{route('teamquery')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon2.png" alt="Assets Icon">
                        <h5 class="ad-title mb-0">Query</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
<div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamque">
                <a href="{{route('teamassets')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon2.png" alt="Assets Icon">
                        <h5 class="ad-title mb-0">Assets</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

  

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamelig">
                <a href="{{route('teameligibility')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <h5 class="ad-title mb-0">Eligibility CTC</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamcost">
                <a href="{{route('teamcost')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <h5 class="ad-title mb-0">Cost</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card">
                <a href="{{route('teamconfirmation')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <h5 class="ad-title mb-0">Confirm<sup>n</sup></h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamtraining">
                <a href="{{route('teamtrainingsep')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon5.png" alt="Training Icon">
                        <h5 class="ad-title mb-0">LMS</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamclear">
                <a href="{{route('teamseprationclear')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon5.png" alt="Training Icon">
                        <h5 class="ad-title mb-0">Sepr<sup>n</sup>/<br>Clearance</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="teamatt">
                <a href="{{route('teamleaveatt')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon1.png" alt="Attendance Icon">
                        <h5 class="ad-title mb-0">Att.<br>/Leave</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d menu-card" id="team">
                <a href="{{route('team')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon1.png" alt="Attendance Icon">
                        <h5 class="ad-title mb-0">Team's Details</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuCards = document.querySelectorAll('.menu-card'); // Select cards with 'menu-card' class

    // Retrieve active card index from localStorage
    const activeCardIndex = localStorage.getItem('activeCardIndex');

    // If an active card index is found, add 'active-card' class to the respective card
    if (activeCardIndex !== null) {
        menuCards[activeCardIndex].classList.add('active-card');
    }

    // Add click event listener to each menu card
    menuCards.forEach((card, index) => {
        card.addEventListener('click', function () {
            // Remove 'active-card' class from all cards
            menuCards.forEach(c => c.classList.remove('active-card'));

            // Add 'active-card' class to the clicked card
            card.classList.add('active-card');

            // Store the index of the active card in localStorage
            localStorage.setItem('activeCardIndex', index);
        });
    });
});

</script>
