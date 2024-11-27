
    // Handle toggling of additional salary components for each employee
    document.querySelectorAll('.toggle-symbol').forEach(symbol => {
        symbol.addEventListener('click', function() {
            const employeeId = this.closest('tr').getAttribute('data-employee');
            const salaryRows = document.querySelectorAll(`#salaryTable-${employeeId} .salary-row:not(.gross-earning)`); // exclude gross-earning row
            let isExpanded = false;

            // Check if any non-Gross Earning rows are currently shown
            salaryRows.forEach(row => {
                if (row.style.display === 'table-row') {
                    isExpanded = true;
                }
            });

            // Toggle visibility of salary rows for the current employee, excluding the "Gross Earning" row
            salaryRows.forEach(row => {
                if (isExpanded) {
                    row.style.display = 'none'; // Hide the row if expanded
                } 
                else {
                    row.style.display = 'table-row'; // Show the row if hidden
                }
            });

            // Toggle the symbol text between "↓" and "↑"
            this.textContent = isExpanded ? '↓' : '↑';
        });
    });
