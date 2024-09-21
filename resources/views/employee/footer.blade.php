<Script>
	function toggleChat() {
    var chatBody = document.getElementById("chatBody");
    var expandCollapseIcon = document.querySelector(".expand-collapse");
    
    if (chatBody.style.display === "none" || chatBody.style.display === "") {
        chatBody.style.display = "block";
        expandCollapseIcon.textContent = "▼";
    } else {
        chatBody.style.display = "none";
        expandCollapseIcon.textContent = "▲";
    }
}

// Function to switch between Task and Chat tabs
function openTab(tabName) {
    var i, tabContent, tabButtons;

    // Get all elements with class "tab-content" and hide them
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    // Get all elements with class "tab-btn" and remove the "active" class
    tabButtons = document.getElementsByClassName("tab-btn");
    for (i = 0; i < tabButtons.length; i++) {
        tabButtons[i].className = tabButtons[i].className.replace(" active", "");
    }

    // Show the selected tab and add "active" class to the clicked button
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active";
}

// Set the default tab to be open
document.getElementById("task").style.display = "block";
	</Script>
    <!-- Preview Setting -->
	
	
    <!-- Script Start -->
	<script src="{{asset('../js/jquery.min.js')}}"></script>
    <script src="{{asset('../js/popper.min.js')}}"></script>
    <script src="{{asset('../js/bootstrap.min.js')}}"></script>
	<script src="{{asset('../js/swiper.min.js')}}"></script>
    <script src="{{asset('../js/apexcharts.min.js')}}"></script>
    <script src="{{asset('../js/control-chart-apexcharts.js')}}"></script>
	<!-- Page Specific -->
    <script src="{{asset('../js/nice-select.min.js')}}"></script>
    <!-- Custom Script -->
	<script src="{{asset('../js/calendar.min.js')}}"></script>
    <script src="{{asset('../js/custom.js')}}"></script>
	<script>
		function selectDate(date) {
		  $('.calendar-wrapper').updateCalendarOptions({
			date: date
		  });
		}

		var defaultConfig = {
		  weekDayLength: 1,
		  date: new Date(),
		  onClickDate: selectDate,
		  showYearDropdown: true,
		  startOnMonday: true,
		};

		$('.calendar-wrapper').calendar(defaultConfig);
	</script>
</body></html>