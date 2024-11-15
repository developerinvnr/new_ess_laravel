
//inst.declaration /submission js 

// Get the current year
const currentYear = new Date().getFullYear();
// Get the previous year
const FutureYear = currentYear + 1;

// Format the string dynamically
const formattedText = `Investment Declaration Form ${currentYear}-${FutureYear}`;

// Update the content of the h4 element
document.getElementById('investment-title').textContent = formattedText;

document.addEventListener('DOMContentLoaded', function () {
    // LTA Checkbox and Amount
    const ltaCheckbox = document.getElementById('lta-checkbox');
    const ltaAmountInput = document.getElementById('lta-amount');

    // CEA Checkboxes and Amount
    const child1Checkbox = document.getElementById('child1-checkbox');
    const child2Checkbox = document.getElementById('child2-checkbox');
    const ceaAmountInput = document.getElementById('cea-amount');

    // Update LTA Amount based on Checkbox
    ltaCheckbox.addEventListener('change', function () {
        if (ltaCheckbox.checked) {
            ltaAmountInput.value = '16000'; // Automatically set value when checked
        } else {
            ltaAmountInput.value = ''; // Clear value if unchecked
        }
    });
    
    // Get the value of Curr_CEA (assuming it's already available in the input field)
    const currCEA = parseInt(ceaAmountInput.value || 0);
    
    // Logic to check/uncheck checkboxes based on Curr_CEA value
    if (currCEA === 2400) {
        child1Checkbox.checked = true; // Child 1 checked
        child2Checkbox.checked = true; // Child 2 checked
        ceaAmountInput.value = 2400.00; // Set CEA amount
    } else if (currCEA === 1200) {
        child1Checkbox.checked = true; // Child 1 checked
        child2Checkbox.checked = false; // Child 2 unchecked
        ceaAmountInput.value = 1200.00; // Set CEA amount
    } else {
        child1Checkbox.checked = false; // Child 1 unchecked
        child2Checkbox.checked = false; // Child 2 unchecked
        ceaAmountInput.value = ''; // Clear CEA amount
    }
    
    // Function to update CEA amount dynamically based on checkboxes
    function updateCeaAmount() {
        let totalAmount = 0;
        if (child1Checkbox.checked) totalAmount += 1200; // Child 1
        if (child2Checkbox.checked) totalAmount += 1200; // Child 2
        ceaAmountInput.value = totalAmount; // Update CEA amount
    }
    
    // Attach change event listeners to checkboxes to update CEA amount
    child1Checkbox.addEventListener('change', updateCeaAmount);
    child2Checkbox.addEventListener('change', updateCeaAmount);

    // Set the selected regime based on active tab
    function setRegime(regime) {
        document.getElementById('selected-regime').value = regime;
    }

    // Set the period (previousYear-currentYear) and update the hidden input
    function setPeriod() {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const FutureYear = currentYear + 1;
        const period = `${currentYear}-${FutureYear}`;
        
        document.getElementById('period').value = period;
    }

    // Set the period on page load
    setPeriod();

    // Get form and submit button
    const form = document.getElementById('investment-form');
    const submitButton = document.getElementById('submit-button');

    // Handle form submission with AJAX
    submitButton.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = new FormData(form);

        // Make AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successMessage.textContent = 'Data saved successfully!';
                messageContainer.style.display = 'block';
                form.reset(); // Optionally reset the form                
            } else {
                alert('There was an error. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    });

    // Attach click event listeners to the regime tabs
    const oldRegimeTab = document.getElementById('oldregime-tab1');
    const newRegimeTab = document.getElementById('newregime-tab20');

    // Set initial value based on the default active tab
    setRegime('old'); // Default to 'old' regime

    oldRegimeTab.addEventListener('click', function() {
        setRegime('old'); // Set regime to old
    });

    newRegimeTab.addEventListener('click', function() {
        setRegime('new'); // Set regime to new
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // LTA Checkbox and Amount
    const ltaCheckbox = document.getElementById('lta-checkbox');
    const ltaAmountInput = document.getElementById('lta-amount');

    // CEA Checkboxes and Amount
    const child1Checkbox = document.getElementById('child1-checkbox');
    const child2Checkbox = document.getElementById('child2-checkbox');
    const ceaAmountInput = document.getElementById('cea-amount');

    // Update LTA Amount based on Checkbox
    ltaCheckbox.addEventListener('change', function () {
        if (ltaCheckbox.checked) {
            ltaAmountInput.value = '16000'; // Automatically set value when checked
        } else {
            ltaAmountInput.value = ''; // Clear value if unchecked
        }
    });
    
    // Get the value of Curr_CEA (assuming it's already available in the input field)
    const currCEA = parseInt(ceaAmountInput.value || 0);
    
    // Logic to check/uncheck checkboxes based on Curr_CEA value
    if (currCEA === 2400) {
        child1Checkbox.checked = true; // Child 1 checked
        child2Checkbox.checked = true; // Child 2 checked
        ceaAmountInput.value = 2400.00; // Set CEA amount
    } else if (currCEA === 1200) {
        child1Checkbox.checked = true; // Child 1 checked
        child2Checkbox.checked = false; // Child 2 unchecked
        ceaAmountInput.value = 1200.00; // Set CEA amount
    } else {
        child1Checkbox.checked = false; // Child 1 unchecked
        child2Checkbox.checked = false; // Child 2 unchecked
        ceaAmountInput.value = ''; // Clear CEA amount
    }
    
    // Function to update CEA amount dynamically based on checkboxes
    function updateCeaAmount() {
        let totalAmount = 0;
        if (child1Checkbox.checked) totalAmount += 1200; // Child 1
        if (child2Checkbox.checked) totalAmount += 1200; // Child 2
        ceaAmountInput.value = totalAmount; // Update CEA amount
    }
    
    // Attach change event listeners to checkboxes to update CEA amount
    child1Checkbox.addEventListener('change', updateCeaAmount);
    child2Checkbox.addEventListener('change', updateCeaAmount);

    // Set the selected regime based on active tab
    function setRegime(regime) {
        document.getElementById('selected-regime').value = regime;
    }

    // Set the period (previousYear-currentYear) and update the hidden input
    function setPeriod() {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const FutureYear = currentYear + 1;
        const period = `${currentYear}-${FutureYear}`;
        
        document.getElementById('period').value = period;
    }

    // Set the period on page load
    setPeriod();

    // Get form and submit button
    const form = document.getElementById('investment-form-submission');
    const submitButton = document.getElementById('submit-button-sub');

    // Handle form submission with AJAX
    submitButton.addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = new FormData(form);

        // Make AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                successMessage.textContent = 'Data saved successfully!';
                messageContainer.style.display = 'block';
                form.reset(); // Optionally reset the form                
            } else {
                alert('There was an error. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again later.');
        });
    });

    // Attach click event listeners to the regime tabs
    const oldRegimeTab = document.getElementById('oldregime-tab1');
    const newRegimeTab = document.getElementById('newregime-tab20');

    // Set initial value based on the default active tab
    setRegime('old'); // Default to 'old' regime

    oldRegimeTab.addEventListener('click', function() {
        setRegime('old'); // Set regime to old
    });

    newRegimeTab.addEventListener('click', function() {
        setRegime('new'); // Set regime to new
    });
});




