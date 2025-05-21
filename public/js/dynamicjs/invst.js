//inst.declaration /submission js 
// Get the current year
const currentYear = new Date().getFullYear();
// Get the previous year
const FutureYear = currentYear + 1;
     
// Format the string dynamically
// const formattedText = `Investment Declaration Form ${currentYear}-${FutureYear}`;

// Update the content of the h4 element
// document.getElementById('investment-title').textContent = formattedText;

document.addEventListener('DOMContentLoaded', function () {
    // Declare elements
    const child1Checkbox = document.getElementById('child1-checkbox');
    const child2Checkbox = document.getElementById('child2-checkbox');
    const child1Checkboxsub = document.getElementById('child1-checkboxsub');
    const child2Checkboxsub = document.getElementById('child2-checkboxsub');
    const ceaAmountInput = document.getElementById('cea-amount');
    const ceaamountreadonly = document.getElementById('cea-amount-readonly');

    // Update LTA Amount based on Checkbox
    const ltaCheckbox = document.getElementById('lta-checkbox'); // Assuming lta-checkbox is defined in the HTML
    const ltaCheckboxsub = document.getElementById('lta-checkboxsub'); // Assuming lta-checkbox is defined in the HTML

    const ltaAmountInput = document.getElementById('lta-amount'); // Assuming lta-amount is defined in the HTML

    ltaCheckbox.addEventListener('change', function () {
        if (ltaCheckbox.checked) {
            ltaAmountInput.value = ltaAmountInput.getAttribute('data-lta-value'); // Set stored value
        } else {
            ltaAmountInput.value = ''; // Clear value if unchecked
        }
    });


    const ltaAmountInputsub = document.getElementById('hra-readonly'); // Assuming lta-amount-input is defined in the HTML
    ltaCheckbox.addEventListener('change', function () {
        if (ltaCheckbox.checked) {
            ltaAmountInput.value = '16000'; // Automatically set value when checked
        } else {
            ltaAmountInput.value = ''; // Clear value if unchecked
        }
    });

    // Logic for child checkboxes and CEA amount for the first section
    const currCEA = parseInt(ceaAmountInput.value || 0);
    if (currCEA === 2400) {
        child1Checkbox.checked = true;
        child2Checkbox.checked = true;
        ceaAmountInput.value = 2400.00; // Set CEA amount
    } else if (currCEA === 1200) {
        child1Checkbox.checked = true;
        child2Checkbox.checked = false;
        ceaAmountInput.value = 1200.00; // Set CEA amount
    } else {
        child1Checkbox.checked = false;
        child2Checkbox.checked = false;
        ceaAmountInput.value = ''; // Clear CEA amount
    }
    // Logic for child checkboxes and CEA amount for the second section (readonly)
    const ceaamountreadonlya = parseInt(ceaamountreadonly.value || 0);
    if (ceaamountreadonlya === 2400) {
        child1Checkboxsub.checked = true;
        child2Checkboxsub.checked = true;
        ceaamountreadonly.value = 2400.00; // Set CEA amount
    } else if (ceaamountreadonlya === 1200) {
        child1Checkboxsub.checked = true;
        child2Checkboxsub.checked = false;
        ceaamountreadonly.value = 1200.00; // Set CEA amount
    } else {
        child1Checkboxsub.checked = false;
        child2Checkboxsub.checked = false;
        ceaamountreadonly.value = ''; // Clear CEA amount
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
    // function setPeriod() {
    //     const currentDate = new Date();
    //     const currentYear = currentDate.getFullYear();
    //     const FutureYear = currentYear + 1;
    //     const period = `${currentYear}-${FutureYear}`;
        
    //     document.getElementById('period').value = period;
    // }

    // // Set the period on page load
    // setPeriod();

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
        const activeTab = document.querySelector('.nav-link.active');
        if (activeTab) {
            const activeTabHref = activeTab.getAttribute('href');
            localStorage.setItem('activeTab', activeTabHref); // Store the active tab href in localStorage
            console.log('Active Tab Stored:', activeTabHref);
        }
    
        // Make AJAX request
        fetch(form.action, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            $('#loader').hide(); 
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

  
    // // Attach click event listeners to the regime tabs

});

// Listen for tab activation and store the active tab dynamically
document.querySelectorAll('.nav-link').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (e) {
        const activeTabHref = e.target.getAttribute('href'); // Get the href of the activated tab
        if (activeTabHref) {
            localStorage.setItem('activeTab', activeTabHref); // Store the active tab href in localStorage
            console.log('Active Tab Stored:', activeTabHref);
        }
    });
});

// Restore the active tab on page load
document.addEventListener('DOMContentLoaded', function () {
    const activeTabHref = localStorage.getItem('activeTab'); // Retrieve the active tab's href
    if (activeTabHref) {
        const tabToActivate = document.querySelector(`.nav-link[href="${activeTabHref}"]`); // Find the tab with the matching href
        if (tabToActivate) {
            const tabInstance = new bootstrap.Tab(tabToActivate); // Create a Bootstrap Tab instance
            tabInstance.show(); // Activate the tab
            console.log('Active Tab Restored:', activeTabHref);
        }
    }

});


document.addEventListener('DOMContentLoaded', function () {
    // LTA Checkbox and Amount
    const ltaCheckbox = document.getElementById('lta-checkbox');
    const ltaAmountInput = document.getElementById('lta-amount');

    // CEA Checkboxes and Amount
    const child1Checkbox = document.getElementById('child1-checkbox');
    const child2Checkbox = document.getElementById('child2-checkbox');
    const ceaAmountInput = document.getElementById('cea-amount');

    // Set default LTA value
    if (!ltaCheckbox.checked) {
        ltaAmountInput.value = '0';
    }

    // LTA Checkbox change handler
    ltaCheckbox.addEventListener('change', function () {
        if (ltaCheckbox.checked) {
            ltaAmountInput.value = ltaAmountInput.getAttribute('data-lta-value') || '0';
        } else {
            ltaAmountInput.value = '0'; // Default to 0 when unchecked
        }
    });

    // Set default CEA value logic
    let currCEA = parseInt(ceaAmountInput.value || '0');

    if (currCEA === 2400) {
        child1Checkbox.checked = true;
        child2Checkbox.checked = true;
        ceaAmountInput.value = '2400';
    } else if (currCEA === 1200) {
        child1Checkbox.checked = true;
        child2Checkbox.checked = false;
        ceaAmountInput.value = '1200';
    } else {
        child1Checkbox.checked = false;
        child2Checkbox.checked = false;
        ceaAmountInput.value = '0';
    }

    // Function to update CEA amount dynamically based on checkboxes
    function updateCeaAmount() {
        let totalAmount = 0;
        if (child1Checkbox.checked) totalAmount += 1200;
        if (child2Checkbox.checked) totalAmount += 1200;
        ceaAmountInput.value = totalAmount.toString();
    }

    // Attach event listeners for CEA
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
// Get form and buttons
// const form = document.getElementById('investment-form-submission');
// Get buttons for both regimes
const saveButton = document.getElementById('save-button-sub');
const submitButton = document.getElementById('submit-button-sub');

// Function to handle form submission for both regimes
function handleFormSubmission(e, actionType) {
    e.preventDefault(); // Prevent default form submission

    // Determine which form to use based on the button clicked
    const form = e.target.closest('form'); // Automatically gets the correct form
    console.log('Form Submission for:', actionType);

    // Collect form data
    const formData = new FormData(form);

    // Get selected regime from the hidden field inside the form
    const selectedRegime = form.querySelector('input[name="selected_regime"]').value;

    // Append action type ('submit', 'save', 'submitnew', 'savenew') to the form data
    formData.append(actionType, actionType === 'submit' || actionType === 'submitnew' ? 1 : 0);

    // Add regime information to the form data
    formData.append('regime', selectedRegime);

    // Disable submit button and show loader
    $(form).find('button[type="submit"]').prop('disabled', true);
    $('#loader').show(); // Show the loader while processing

    // Get CSRF token
    const token = $('input[name="_token"]').val();

    // Perform the AJAX request to submit the form data
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        $('#loader').hide(); // Hide the loader after receiving the response

        if (data.success) {
            // Show success message using toastr
            toastr.success(data.message, 'Success', {
                "positionClass": "toast-top-right",
                "timeOut": 3000
            });

            // Optionally reload the page after a delay
            setTimeout(function () {
                location.reload();
            }, 3000);
        } else {
            // Show error message using toastr
            toastr.error(data.message, 'Error', {
                "positionClass": "toast-top-right",
                "timeOut": 3000
            });

            // Re-enable the submit button if there's an error
            $(form).find('button[type="submit"]').prop('disabled', false);
        }
    })
    .catch(error => {
        // Handle errors in the fetch request
        $(form).find('button[type="submit"]').prop('disabled', false);
        $('#loader').hide();
        toastr.error('An error occurred while submitting the form. Please try again.', 'Error', {
            "positionClass": "toast-top-right",
            "timeOut": 3000
        });
        console.error('Error:', error);
    });
}

// New Regime Save Button
saveButton.addEventListener('click', function (e) {
    e.preventDefault(); // Prevent normal form submission
    handleFormSubmission(e, 'save');
});

// New Regime Submit Button
submitButton.addEventListener('click', function (e) {
    e.preventDefault(); // Prevent normal form submission
    handleFormSubmission(e, 'submit');
});

});


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
//   document.querySelector('button[type="reset"]').addEventListener('click', resetMessages);
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


// function disableForm() {
// const form = document.getElementById('investment-form');
// const elements = form.elements; // Access all elements in the form

// for (let i = 0; i < elements.length; i++) {
//     const element = elements[i];
//     if (element.id !== 'submit-button' && element.id !== 'reset-button') {
//         element.disabled = true; // Disable all except the "Edit" and "Reset" buttons
//     }
// }

// console.log('The entire form has been disabled.');
// }

// // Trigger the function (example: immediately after page load)
// window.onload = disableForm;
// // Function to enable all form fields
// function enableForm() {
// const form = document.getElementById('investment-form');
// const elements = form.elements; // Access all elements in the form

// for (let i = 0; i < elements.length; i++) {
// elements[i].disabled = false; // Enable each element
// }

// console.log('All form fields have been enabled.');
// }
const editButtonSubNew= document.getElementById('edit-button-sub-new');
            if (editButtonSubNew) {
document.getElementById('edit-button-sub-new').addEventListener('click', function () {
// Show the Save button
const saveButton = document.getElementById('save-button-sub-new');
saveButton.style.display = 'inline-block';
    // Sec. 80CCD(2) - Corporate NPS Scheme
    const corNpsReadonlynew = document.getElementById('cornps_readonly_new').value;
    console.log(corNpsReadonlynew);
    const corNpsEditablenew = document.getElementById('cornps_edit_new');
    corNpsEditablenew.value = corNpsReadonlynew; // Transfer value
    corNpsEditablenew.removeAttribute('readonly');
});
            }

