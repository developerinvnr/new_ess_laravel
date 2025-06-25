

<Script>
history.pushState(null, null, location.href);
window.addEventListener('popstate', function () {
  history.pushState(null, null, location.href);
});

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

	<!-- Page Specific -->
    <script src="{{asset('../js/nice-select.min.js')}}"></script>
    <!-- Custom Script -->
	<script src="{{asset('../js/calendar.min.js')}}"></script>
    <script src="{{asset('../js/custom.js')}}"></script>
    

    <!-- Bootstrap JS and dependencies (including Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
  
    <!-- Include jQuery and DataTables JS -->
    <!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>-->
    <!--<script src="https://code.jquery.com/jquery-3.7.1.js"></script>-->

   <!-- Include jQuery and DataTables JS -->
   <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
   <script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
   <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>

   
   <script src="https://cdn.jsdelivr.net/npm/orgchart@2.0.4/dist/js/jquery.orgchart.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


	<script>

        $(document).ready(function () {
            let windowHeight = $(window).height();
            let scrollHeight = windowHeight * 0.55;
            //var scrollHeight = windowHeight * 0.7;
            $('#atttable').DataTable({
                scrollY: scrollHeight,
                scrollX: true,
                scrollCollapse: true,
                destroy: true,
                searching: true,
                paging: false,
                info: false,
                ordering: false,
                fixedColumns: {
                    left: 8,

                },
                fixedHeader: {
                    header: true,
                    footer: true
                }
            });
        });


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
        $(document).ready(function() {
            $('.calender-show-btn').click(function() {
                $('.calendar-wrapper').toggle();
            });
        });
// Disable right-click (context menu)
// document.addEventListener('contextmenu', function(e) {
//     e.preventDefault();  // Prevent the context menu from appearing
// });

// Disable certain keyboard shortcuts (F12, Ctrl+Shift+I, Ctrl+U)
document.addEventListener('keydown', function(e) {
    // Check for F12 key
    if (e.key === 'F12') {
        e.preventDefault();
    }
    // Check for Ctrl+Shift+I (Inspect element)
    if (e.ctrlKey && e.shiftKey && e.key === 'I') {
        e.preventDefault();
    }
    // Check for Ctrl+U (View page source)
    if (e.ctrlKey && e.key === 'U') {
        e.preventDefault();
    }
});

// Disable text selection on mouse down
document.addEventListener('mousedown', function(e) {
    e.preventDefault();  // Disable text selection on mouse down
});


</script>
</body></html>