<div class="row">
<div class="col">
					<div class="card ad-info-card-">
						<div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
							<a href="{{route('team')}}">
								<div class="icon-info-text-n d-flex align-items-center">
									<img style="width:30px; margin-right: 10px;" src="./images/icons/icon1.png" alt="Attendance Icon">
									<h5 class="ad-title mb-0">Team's Details</h5>
								</div>
							</a>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card ad-info-card-">
						<div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
							<a href="{{route('teamleaveatt')}}">
								<div class="icon-info-text-n d-flex align-items-center">
									<img style="width:30px; margin-right: 10px;" src="./images/icons/icon1.png" alt="Attendance Icon">
									<h5 class="ad-title mb-0">Attend.<br>Leave</h5>
								</div>
							</a>
						</div>
					</div>
				</div>


    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="{{route('teamassetsquery')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon2.png" alt="Assets Icon">
                        <h5 class="ad-title mb-0">Assets<br>Query</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="{{route('teameligibility')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <br>
                        
                        <h5 class="ad-title mb-0">Eligibility
                            <br>

                            <!-- CTC -->
                        </h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="{{route('teamcost')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <br>
                        
                        <h5 class="ad-title mb-0">Cost
                            <br>

                        </h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="{{route('teamconfirmation')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/eligibility-icon.png" alt="Eligibility Icon">
                        <h5 class="ad-title mb-0">Confirm<sup>n</sup></h5>
                    </div>
                </a>
            </div>
        </div>
    </div> -->

    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="{{route('teamtrainingsep')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon5.png" alt="Training Icon">
                        <br>
                        <h5 class="ad-title mb-0">LMS
                            
                            <br>

                        </h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card ad-info-card-">
            <div class="card-body d-flex align-items-center justify-content-center border-bottom-d">
                <a href="{{route('teamseprationclear')}}">
                    <div class="icon-info-text-n d-flex align-items-center">
                        <img style="width:30px; margin-right: 10px;" src="./images/icons/icon5.png" alt="Training Icon">
                        <h5 class="ad-title mb-0">Seperation<br>Clearance</h5>
                    </div>
                </a>
            </div>
        </div>
    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.card-body');

    // Check if there is any active card stored in localStorage
    const activeCardIndex = localStorage.getItem('activeCardIndex');

    // If an active card is stored, add the active class to the respective card
    if (activeCardIndex !== null) {
        cards[activeCardIndex].classList.add('active');
    } else {
        // If no active card is stored, add the active class to the first card
        cards[0].classList.add('active');
        // Store the index of the first card as active in localStorage
        localStorage.setItem('activeCardIndex', 0);
    }

    // Add a click event listener to each card
    cards.forEach((card, index) => {
        card.addEventListener('click', function () {
            // Remove 'active' class from all cards
            cards.forEach(c => c.classList.remove('active'));

            // Add 'active' class to the clicked card
            card.classList.add('active');

            // Store the index of the active card in localStorage
            localStorage.setItem('activeCardIndex', index);
        });
    });
});


</script>
<style>


/* Active state when the card is clicked */
.card-body.active {
    /* background-color: #ccc;  */
    /* Gray background when active */
    /* color: #fff;  */
    /* White text when active */
}

/* Hover effect to indicate that the card can be clicked */
.card-body:hover {
    /* background-color: #f0f0f0; */
}

</style>