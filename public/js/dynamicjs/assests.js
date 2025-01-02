
// When an asset is selected
// $('#asset').on('change', function () {
//     // Get the selected option
//     var selectedOption = $(this).find('option:selected');

//     // Retrieve the asset limit from the data attribute
//     var limit = selectedOption.data('limit');

//     // Set the maximum limit value to the input field
//     $('#maximum_limit').val(limit);
// });
$('#asset').on('change', function () {
    // Get the selected option
    var selectedOption = $(this).find('option:selected');

    // Retrieve the asset limit from the data attribute
    var limit = selectedOption.data('limit');

    // If the limit is not 'none', set it to the input field
    if (limit !== 'none') {
        $('#maximum_limit').val(limit); // Set the maximum limit value
        $('#maximum_limit').prop('disabled', false); // Enable the input field
        $('#max_limit').show(); // Show the div
    } else {
        $('#maximum_limit').val(''); // Clear the value
        $('#maximum_limit').prop('disabled', true); // Disable the input field
        $('#max_limit').hide(); // Hide the div
    }
});




$('#fileModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var fileUrl = button.data('file-url');
    var fileType = button.data('file-type');

    var filePreviewContainer = $('#filePreviewContainer');

    filePreviewContainer.empty();

    if (fileType === 'bill' || fileType === 'asset') {
        var imageElement = $('<img />', {
            src: fileUrl,
            class: 'img-fluid',
            alt: 'File preview',
        });

        filePreviewContainer.append(imageElement);
    } else {
        filePreviewContainer.append('<p>Unsupported file type</p>');
    }
});
$('#pdfModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget); // Button that triggered the modal
var fileUrl = button.data('file-url'); // Extract file URL (PDF URL)

var pdfCarouselContent = $('#pdfCarouselContent');
var pdfCarousel = $('#pdfCarousel');

pdfCarouselContent.empty(); // Clear carousel content

// Hide carousel initially
pdfCarousel.hide();

// Load the PDF
var loadingTask = pdfjsLib.getDocument(fileUrl);

loadingTask.promise.then(function (pdf) {
var totalPages = pdf.numPages;

// Render all pages and add to the carousel
for (var pageNum = 1; pageNum <= totalPages; pageNum++) {
    renderPage(pdf, pageNum);
}

// Show the carousel after rendering pages
pdfCarousel.show();
}).catch(function (error) {
console.error('Error loading PDF: ' + error);
pdfCarouselContent.append('<p>Unable to load PDF</p>');
});

// Render a specific page of the PDF in the carousel
function renderPage(pdf, pageNum) {
pdf.getPage(pageNum).then(function (page) {
    // Set a fixed height of 500px for the PDF container
    var fixedHeight = 800;

    // Calculate scale based on fixed height (preserving aspect ratio)
    var scale = fixedHeight / page.getViewport({ scale: 1 }).height;

    var viewport = page.getViewport({ scale: scale });
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render the page
    page.render({ canvasContext: context, viewport: viewport }).promise.then(function () {
        // Add rendered page to carousel
        var isActive = pageNum === 1 ? 'active' : ''; // First page is active
        var slide = $('<div class="carousel-item ' + isActive + '">')
            .append(canvas);
        
        pdfCarouselContent.append(slide);
    });
});
}
});

// When the modal is shown, populate it with dynamic data
$('#assetdetails').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract data attributes from the button
    var requestDate = button.data('request-date');
    var assetType = button.data('asset-type');
    var price = button.data('price');
    var reqAmt = button.data('req-amt');
    var approvalAmt = button.data('approval-amt');
    var billCopy = button.data('bill-copy');
    var assetCopy = button.data('asset-copy');
    var identityRemark = button.data('identity-remark');

    // Populate the modal with the extracted data
    $('#modalRequestDate').text(requestDate);
    $('#modalAssetType').text(assetType);
    $('#modalPrice').text(price);
    $('#modalReqAmt').text(reqAmt);
    $('#modalApprovalAmt').text(approvalAmt);
    $('#modalIdentityRemark').text(identityRemark);

    // Update the modal image sources
    $('#modalBillCopy').attr('src', billCopy || ''); // if no bill copy, leave empty
    $('#modalAssetCopy').attr('src', assetCopy || ''); // if no asset copy, leave empty
});
$('#approvalModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    
    // Extract data from the button's data attributes
    var assestsid = button.data('request-id');
    var employeeId = button.data('employee-id');
    var employeeName = button.data('employee-name');
    var assetId = button.data('asset-id');
    var reqAmt = button.data('req-amt');
    var reqDate = button.data('req-date');
    
    // Get today's date in YYYY-MM-DD format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    // Set the values in the form fields
    // $('#assestsid').val(assestsid);
    $('#employee_id').val(employeeId);
    $('#employee_name').val(employeeName); // For hidden input
    $('#employee_name_span').text(employeeName); // Display Employee Name in span
    $('#asset_id').val(assetId); // For hidden input
    $('#asset_id_span').text(assetId); // Display Asset ID in span
    $('#req_amt').val(reqAmt); // For hidden input
    $('#req_amt_span').text(reqAmt); // Display Request Amount in span
    $('#reg_Date').val(reqDate); // For hidden input
    $('#reg_Date_span').text(reqDate); // Display Reg Date in span
    $('#approval_date').val(today);  // Set today's date
    $('#employeeId').val(employeeId);  // Set the Employee ID

    // Reset the form fields first, before checking and displaying any data
    $('#approval_status').val('');  // Reset approval status dropdown to default
    $('#remark').val('');  // Clear the remark field

    // Handle Approval Status based on the role (HOD, IT, Accounts)
    if (button.data('hod-approval-status') !== undefined) {
        var hodApprovalStatus = button.data('hod-approval-status');
        // Set the value to 'approved' if 1, 'rejected' if 0
        $('#approval_status').val(hodApprovalStatus === 1 ? '1' : '0');
        $('#remark').val(button.data('hod-remark'));
    } else if (button.data('it-approval-status') !== undefined) {
        var itApprovalStatus = button.data('it-approval-status');
        // Set the value to 'approved' if 1, 'rejected' if 0
        $('#approval_status').val(itApprovalStatus === 1 ? '1' : '0');
        $('#remark').val(button.data('it-remark'));
    } else if (button.data('acc-approval-status') !== undefined) {
        var accApprovalStatus = button.data('acc-approval-status');
        // Set the value to 'approved' if 1, 'rejected' if 0
        $('#approval_status').val(accApprovalStatus === 1 ? '1' : '0');
        $('#remark').val(button.data('acc-remark'));
    } else {
        // If no approval status data is found, both fields will remain empty
        $('#approval_status').val('');  // Reset to default if no status
        $('#remark').val('');
    }
});

// $('#approvalModal').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget); // Button that triggered the modal
//     var assestsid = button.data('request-id');
//     var employeeId = button.data('employee-id');
//     var employeeName = button.data('employee-name');
//     var assetId = button.data('asset-id');
//     var reqAmt = button.data('req-amt');
//     var reqDate = button.data('req-date');
//     var reqAmtPerMonth = button.data('req-amt-per-month');
//     var modelName = button.data('model-name');
//     var companyName = button.data('company-name');
//     var dealerNumber = button.data('dealer-number');
//     var today = new Date();
//     var dd = String(today.getDate()).padStart(2, '0');
//     var mm = String(today.getMonth() + 1).padStart(2, '0');
//     var yyyy = today.getFullYear();
//     var hodApprovalStatus = button.data('approval-status-hod'); // Add HOD Approval Status
//     var itApprovalStatus = button.data('approval-status-it'); // Add IT Approval Status
//     var payAmt = button.data('pay-amt'); // Pay Amount
//     var payDate = button.data('pay-date'); // Pay Date

   
//     today = yyyy + '-' + mm + '-' + dd;

//     // Set values in the modal form fields
//     $('#assestsid').val(assestsid);
//     $('#employee_id').val(employeeId);
//     $('#employee_name').val(employeeName);
//     $('#asset_id').val(assetId);
//     $('#req_amt').val(reqAmt);
//     $('#approval_status').val('');
//     $('#remark').val('');
//     $('#reg_Date').val(reqDate);
//     $('#approval_date').val(today);
//     $('#employeeId').val(employeeId);

//     // Display values next to the labels, if available
//     if (employeeName) {
//         $('#employee_name_label').text(employeeName);
//         $('#employee_name').hide();  // Hide the input field if a value exists
//     } else {
//         $('#employee_name').show();  // Show the input field if no value
//     }

//     if (reqAmt) {
//         $('#req_amt_label').text(reqAmt);
//         $('#req_amt').hide();  // Hide the input field if a value exists
//     } else {
//         $('#req_amt').show();  // Show the input field if no value
//     }

//     if (reqDate) {
//         $('#req_date_label').text(reqDate);
//         $('#reg_Date').hide();  // Hide the input field if a value exists
//     } else {
//         $('#reg_Date').show();  // Show the input field if no value
//     }
//     // Conditional logic for showing Pay Amount and Pay Date fields
//     // Show Pay Amount and Pay Date fields based on approval statuses
//     if (hodApprovalStatus == 2 && itApprovalStatus == 2) {
//         $('#payDateDiv').show();  // Show the Pay Date field
//         $('#payAmountDiv').show();  // Show the Pay Amount field

//         // Show Pay Amount in span if available
//         if (payAmt) {
//             $('#pay_amt_span').text(payAmt);  // Display Pay Amount in span
//             $('#pay_amt').hide();  // Hide input field
//             $('#pay_amt_span').show();  // Show span with the value
//         } else {
//             $('#pay_amt').show();  // Show input field if no Pay Amount
//             $('#pay_amt_span').hide();  // Hide span if no Pay Amount
//         }

//         // Show Pay Date in span if available
//         if (payDate) {
//             $('#pay_date_span').text(payDate);  // Display Pay Date in span
//             $('#pay_date').hide();  // Hide input field
//             $('#pay_date_span').show();  // Show span with the value
//         } else {
//             $('#pay_date').show();  // Show input field if no Pay Date
//             $('#pay_date_span').hide();  // Hide span if no Pay Date
//         }
//     } else {
//         // Hide Pay Amount and Pay Date fields if approval status is not 2
//         $('#payDateDiv').hide();
//         $('#payAmountDiv').hide();
//     }
//     // Show the current date next to the label for approval date
//     // $('#approval_date_label').text(today);
//     // $('#approval_date').show(); // Ensure approval date input is visible
// });

// // approval js 
// $('#approvalModal').on('show.bs.modal', function (event) {
// var button = $(event.relatedTarget); // Button that triggered the modal
// var assestsid = button.data('request-id');
// var employeeId = button.data('employee-id');
// var employeeName = button.data('employee-name');
// var assetId = button.data('asset-id');
// var reqAmt = button.data('req-amt');
// var reqDate = button.data('req-date');
// var reqAmtPerMonth = button.data('req-amt-per-month');
// var modelName = button.data('model-name');
// var companyName = button.data('company-name');
// var dealerNumber = button.data('dealer-number');
// var today = new Date();
// var dd = String(today.getDate()).padStart(2, '0');
// var mm = String(today.getMonth() + 1).padStart(2, '0');
// var yyyy = today.getFullYear();

// today = yyyy + '-' + mm + '-' + dd;
// var employeeIds = employeeId;


// // Set values in the modal form fields
// $('#assestsid').val(assestsid);
// $('#employee_id').val(employeeId);
// $('#employee_name').val(employeeName); // Display Employee Name
// $('#asset_id').val(assetId);
// $('#req_amt').val(reqAmt);
// $('#approval_status').val('');
// $('#remark').val('');
// $('#reg_Date').val(reqDate);
// $('#approval_date').val(today);  // Set the value of the input
// $('#employeeId').val(employeeIds);  // Set the value of the input

// });
document.addEventListener('DOMContentLoaded', function() {
    // Show the first approval status by default
    const firstRequestId = document.querySelector('.btn-outline.success-outline.sm-btn')?.getAttribute('data-request-id');
    if (firstRequestId) {
        showApprovalStatus(firstRequestId);  // Show the first request's approval section
    }

    // Attach click event listener to all View buttons
    const viewButtons = document.querySelectorAll('.btn-outline.success-outline.sm-btn');
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const requestId = this.getAttribute('data-request-id');
            showApprovalStatus(requestId);
        });
    });
    
    // Function to show only the relevant approval status
    function showApprovalStatus(requestId) {
        // Hide all approval sections first
        const allApprovalSections = document.querySelectorAll('.exp-details-box');
        allApprovalSections.forEach(section => {
            section.style.display = 'none';
        });

        // Show the approval section related to the clicked request
		const approvalSectionHOD = document.getElementById('approvalhod-' + requestId);
        if (approvalSectionHOD) {
            approvalSectionHOD.style.display = 'block';
        }
        const approvalSectionIT = document.getElementById('approvalit-' + requestId);
        if (approvalSectionIT) {
            approvalSectionIT.style.display = 'block';
        }
        const approvalSectionACCT = document.getElementById('approvalacct-' + requestId);
        if (approvalSectionACCT) {
            approvalSectionACCT.style.display = 'block';
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {

 
function validatePhoneNumber() {
    var phoneInput = document.getElementById('dealer_contact');
    var errorMessage = document.getElementById('phoneError');
    var phoneValue = phoneInput.value;
    console.log(phoneValue);

    // Check if the input is either 10 or 12 digits long
    var phoneRegex = /^\d{10}$|^\d{12}$/; // matches 10 or 12 digit numbers

    if (!phoneRegex.test(phoneValue)) {
        // Show error message if input is invalid
        errorMessage.style.display = 'block';
        phoneInput.classList.add('is-invalid'); // Optionally add a red border
    } else {
        // Hide error message if input is valid
        errorMessage.style.display = 'none';
        phoneInput.classList.remove('is-invalid');
    }
}

    // Form submit event listener
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        let isValid = true;

        // Validate required fields and custom checks
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        
        // Loop through all required fields
        requiredFields.forEach(function(field) {
            // Check if field is empty or invalid
            if (!field.checkValidity()) {
                isValid = false;
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }

            // Custom validation for phone number
            if (field.id === 'dealer_contact') {
                validatePhoneNumber();  // Check phone number
            }
        });

        // If the form is not valid, prevent submission and show an alert
        if (!isValid) {
            event.preventDefault();
            alert('Please fill in all required fields correctly before submitting.');
        }
    });

    // Add input event listeners to validate phone number dynamically as user types
    const dealerContactField = document.getElementById('dealer_contact');
    if (dealerContactField) {
        dealerContactField.addEventListener('input', validatePhoneNumber);
    }

});

document.getElementById('asset').addEventListener('change', function () {
    var assetType = this.options[this.selectedIndex].dataset.type; // Get the type of the selected asset
    console.log(assetType);

    // Helper function to show/hide fields and handle the `required` attribute
    function toggleFieldVisibility(fieldId, show, required = false) {
        var field = document.getElementById(fieldId);
        
        // Toggle visibility using display
        if (show) {
            field.style.display = 'block';  // Show the field
            if (required) {
                field.setAttribute('required', true);  // Make the field required
            }
        } else {
            field.style.display = 'none';  // Hide the field
            field.removeAttribute('required');  // Remove required when hidden
        }
    }

    // Check if the asset is vehicle-related (2-wheeler or 4-wheeler)
    if (assetType == "2 Wheeler" || assetType == "4 Wheeler") {
        // Show vehicle-related fields and hide IMEI-related fields
        toggleFieldVisibility('vehicle_photo_field', true, true);
        toggleFieldVisibility('imei_field', false);
        toggleFieldVisibility('asset_id', false);
        toggleFieldVisibility('company_name_id', false);
        toggleFieldVisibility('request_amont_id', false);
        toggleFieldVisibility('max_limit', false);


        toggleFieldVisibility('vehicle_owner', true, true);
        toggleFieldVisibility('vehicle_odo', true, true);
        toggleFieldVisibility('vehicle_odo_current', true, true);
        toggleFieldVisibility('vehicle_ins', true, true);
        toggleFieldVisibility('vehicle_rl', true, true);
        toggleFieldVisibility('vehicle_dl', true, true);
        toggleFieldVisibility('vehicle_regno', true, true);
        toggleFieldVisibility('vehicle_fuel', true, true);
        toggleFieldVisibility('vehicle_brand', true, true);
        toggleFieldVisibility('vehicle_name', true, true);
        toggleFieldVisibility('vehicle_regdate', true, true);
        toggleFieldVisibility('vehcile_price_id', true, true);


        // Remove required from IMEI and add to vehicle fields
        document.getElementById('iemi_no').removeAttribute('required');
        document.getElementById('asset_copy').removeAttribute('required');
        document.getElementById('company_name').removeAttribute('required');
        document.getElementById('request_amount').removeAttribute('required');
        document.getElementById('maximum_limit').removeAttribute('required');




        document.getElementById('vehicle_photo').setAttribute('required', true);
        document.getElementById('vehicle_owner').setAttribute('required', true);
        document.getElementById('vehicle_name').setAttribute('required', true);
        document.getElementById('vehicle_brand').setAttribute('required', true);
        document.getElementById('fuel_type').setAttribute('required', true);
        document.getElementById('registration_number').setAttribute('required', true);
        document.getElementById('registration_date').setAttribute('required', true);
        document.getElementById('dl_copy').setAttribute('required', true);
        document.getElementById('rc_copy').setAttribute('required', true);
        document.getElementById('insurance_copy').setAttribute('required', true);
        document.getElementById('odometer_reading').setAttribute('required', true);
        document.getElementById('currentodometer_reading').setAttribute('required', true);
        document.getElementById('vehicle_price').setAttribute('required', true);
        document.getElementById('ownership').setAttribute('required', true);

        
    } else {
        // Show IMEI-related fields and hide vehicle-related fields
        toggleFieldVisibility('imei_field', true, true);
        toggleFieldVisibility('asset_id', true, true);
        toggleFieldVisibility('company_name_id', true, true);
        toggleFieldVisibility('request_amont_id', true, true);
        toggleFieldVisibility('max_limit', true, true);


        
        toggleFieldVisibility('vehicle_photo_field', false);
        toggleFieldVisibility('vehicle_owner', false);
        toggleFieldVisibility('vehicle_odo', false);
        toggleFieldVisibility('vehicle_odo_current', false);
        toggleFieldVisibility('vehicle_ins', false);
        toggleFieldVisibility('vehicle_rl', false);
        toggleFieldVisibility('vehicle_dl', false);
        toggleFieldVisibility('vehicle_regno', false);
        toggleFieldVisibility('vehicle_fuel', false);
        toggleFieldVisibility('vehicle_brand', false);
        toggleFieldVisibility('vehicle_name', false);
        toggleFieldVisibility('vehicle_regdate', false);
        toggleFieldVisibility('vehcile_price_id', false);

        
        // Remove required from vehicle fields and add to IMEI
        document.getElementById('vehicle_photo').removeAttribute('required');
        document.getElementById('vehicle_owner').removeAttribute('required');
        document.getElementById('vehicle_name').removeAttribute('required');
        document.getElementById('vehicle_brand').removeAttribute('required');
        document.getElementById('fuel_type').removeAttribute('required');
        document.getElementById('registration_number').removeAttribute('required');
        document.getElementById('registration_date').removeAttribute('required');
        document.getElementById('dl_copy').removeAttribute('required');
        document.getElementById('rc_copy').removeAttribute('required');
        document.getElementById('insurance_copy').removeAttribute('required');
        document.getElementById('odometer_reading').removeAttribute('required');
        document.getElementById('currentodometer_reading').removeAttribute('required');
        document.getElementById('vehicle_price').removeAttribute('required');
        document.getElementById('ownership').removeAttribute('required');

        
        document.getElementById('iemi_no').setAttribute('required', true);
        document.getElementById('company_name').setAttribute('required', true);
        document.getElementById('asset_copy').setAttribute('required', true);
        document.getElementById('request_amount').setAttribute('required', true);
        document.getElementById('maximum_limit').setAttribute('required', true);




    }
    
});
   // JavaScript to restrict input to letters and numbers only, and block spaces
   document.getElementById('model_no').addEventListener('input', function (e) {
    this.value = this.value.replace(/[^a-zA-Z0-9]/g, ''); // Remove spaces and special characters
});



