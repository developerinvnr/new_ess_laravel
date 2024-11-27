// JavaScript to Handle Dropdown Change
document.querySelectorAll('.employeeSelect').forEach(function(dropdown) {
    dropdown.addEventListener('change', function() {
        var selectedEmployeeId = this.value;

        // Hide all employee cards initially
        var employeeCards = document.querySelectorAll('.employee-card');
        employeeCards.forEach(function(card) {
            card.style.display = 'none';  // Hide all employee cards initially
        });

        // Show the selected employee's card
        if (selectedEmployeeId) {
            var selectedCard = document.querySelector('.employee-card[data-employeeid="' + selectedEmployeeId + '"]');
            if (selectedCard) {
                selectedCard.style.display = 'block';  // Show the corresponding employee's card
            }
        }

        // Update the dropdown's selected value after displaying the correct card
        var options = this.querySelectorAll('option');
        options.forEach(function(option) {
            if (option.value === selectedEmployeeId) {
                option.selected = true;  // Mark the option as selected
            } else {
                option.selected = false;  // Deselect the other options
            }
        });
    });

    // Initialize dropdown with the first visible employee's card
    var firstVisibleEmployee = document.querySelector('.employee-card[style*="block"]');
    if (firstVisibleEmployee) {
        var firstEmployeeId = firstVisibleEmployee.getAttribute('data-employeeid');
        var firstOption = dropdown.querySelector('option[value="' + firstEmployeeId + '"]');
        if (firstOption) {
            firstOption.selected = true;  // Select the first visible employee
        }
    }
});