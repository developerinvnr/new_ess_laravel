//inst.declaration /submission js 
// Get the current year
const currentYear = new Date().getFullYear();
// Get the previous year
const FutureYear = currentYear + 1;

// Format the string dynamically
// const formattedText = `Investment Declaration Form ${currentYear}-${FutureYear}`;

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
    
    // Elements for showing messages
    const successMessage = document.getElementById('successMessage');
    const messageContainer = document.getElementById('messageContainer');

    // Ensure message elements exist
    if (!successMessage || !messageContainer) {
        console.error('Error: Message elements not found in the DOM.');
        return;
    }
  

    // Handle form submission with AJAX
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        const formData = new FormData(form);

        // Make AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            // Check if the response was successful
            if (data.success) {
                 // Show a success toast notification with custom settings
                 toastr.success(data.message, 'Success', {
                    "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                    "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
                });
        
                // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                setTimeout(function () {
                    location.reload();  // Optionally, reload the page
                }, 3000); // Delay before reset and reload to match the toast timeout
            }
        })
        .catch(error => {
          // Show an error toast notification with custom settings
            toastr.error('Error: ' + response.message, 'Error', {
                "positionClass": "toast-top-right",  // Position the toast at the top-right corner
                "timeOut": 3000                     // Duration for which the toast will be visible (3 seconds)
            });
        });
    });

    // Attach click event listeners to the regime tabs
    const oldRegimeTab = document.getElementById('oldregime-tab1');
    const newRegimeTab = document.getElementById('newregime-tab20');

    // Set initial value based on the default active tab
    setRegime('old'); // Default to 'old' regime

    // oldRegimeTab.addEventListener('click', function() {
    //     setRegime('old'); // Set regime to old
    // });

    // newRegimeTab.addEventListener('click', function() {
    //     setRegime('new'); // Set regime to new
    // });
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
        const period_sub = `${currentYear}-${FutureYear}`;

        // document.getElementById('period_sub').value = period_sub;
    }

    // Set the period on page load
    setPeriod();

    // Get form and submit button
    const form = document.getElementById('investment-form-submission');
    const submitButton = document.getElementById('submit-button-sub');

    // Ensure the message elements exist in the DOM
    const successMessagesub = document.getElementById('successMessagesub');
    const messageContainersub = document.getElementById('messageContainersub');

    // Check if message elements exist
    if (!successMessagesub || !messageContainersub) {
        console.error('Error: Message elements not found in the DOM.');
        return;
    }

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
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            console.log(data);  // Log the response data

            // Check if the response was successful
            if (data.success) {
                // Show the success message from the response
                successMessagesub.textContent = data.message;  // Display message from backend
                successMessagesub.style.color = 'green';  // Success message color
                messageContainersub.style.display = 'block';  // Show the message container
                form.reset(); // Optionally reset the form after submission
                setTimeout(function() {
                    messageContainersub.style.display = 'none';  // Hide the message container
                }, 3000); // 3000ms = 3 seconds
            } else {
                successMessagesub.textContent = 'There was an error. Please try again.'; // Default error message
                successMessagesub.style.color = 'red';  // Error message color
                messageContainersub.style.display = 'block';  // Show the message container
                setTimeout(function() {
                    messageContainersub.style.display = 'none';  // Hide the message container
                }, 3000); // 3000ms = 3 seconds
            }
        })
        .catch(error => {
            console.error('Error:', error);  // Log the error to console
            successMessagesub.textContent = 'An error occurred. Please try again later.'; // Error message on failure
            successMessagesub.style.color = 'red';  // Error message color
            messageContainersub.style.display = 'block';  // Show the message container
        });
    });

    // Attach click event listeners to the regime tabs
    const oldRegimeTab = document.getElementById('oldregime-tab1');
    const newRegimeTab = document.getElementById('newregime-tab20');

    // Set initial value based on the default active tab
    setRegime('old'); // Default to 'old' regime

    oldRegimeTab.addEventListener('click', function () {
        setRegime('old'); // Set regime to old
    });

    newRegimeTab.addEventListener('click', function () {
        setRegime('new'); // Set regime to new
    });
});
  // Reset form and hide success/error messages


  // Optionally, hide the message container and individual messages
  function resetMessages() {
    document.getElementById('investment-form').reset();
        
    // Debugging: Log the form and its inputs after reset
    const form = document.getElementById('investment-form');
    console.log('Form after reset:', form);

    // Log all input fields to check their values
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        console.log(input.name, input.value); // Log name and value of each input
    });
      document.getElementById('messageContainer').style.display = 'none';  // Hide message container
      document.getElementById('successMessage').style.display = 'none';  // Hide success message
  }

  // Call this function when reset button is clicked
  document.querySelector('button[type="reset"]').addEventListener('click', resetMessages);
  function showTab(tabId) {
    // Hide all tabs
    const tabs = document.querySelectorAll('.regim-panel');
    tabs.forEach(tab => {
        tab.classList.remove('show', 'active');
    });

    // Show the selected tab
    const selectedTab = document.getElementById(tabId);
    selectedTab.classList.add('show', 'active');
}
function disableForm() {
const form = document.getElementById('investment-form');
const elements = form.elements; // Access all elements in the form

for (let i = 0; i < elements.length; i++) {
    const element = elements[i];
    if (element.id !== 'submit-button' && element.id !== 'reset-button') {
        element.disabled = true; // Disable all except the "Edit" and "Reset" buttons
    }
}

console.log('The entire form has been disabled.');
}

// Trigger the function (example: immediately after page load)
window.onload = disableForm;
// Function to enable all form fields
function enableForm() {
const form = document.getElementById('investment-form');
const elements = form.elements; // Access all elements in the form

for (let i = 0; i < elements.length; i++) {
elements[i].disabled = false; // Enable each element
}

console.log('All form fields have been enabled.');
}

// Add event listener to the "Edit" button
const editButton = document.getElementById('submit-button');
editButton.addEventListener('click', function (event) {
event.preventDefault(); // Prevent form submission
enableForm(); // Enable the form fields
});



