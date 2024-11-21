$(document).ready(function () {
    // Handle form submission with AJAX
    $('#assetRequestForm').submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Prepare form data (including files)
        var formData = new FormData(this);

        // Show loader (optional, for better UX)
        $('.btn-success').prop('disabled', true).text('Submitting...');

        // Make AJAX request to submit the form
        $.ajax({
            url: asseststoreUrl, // Your Laravel route to handle the form submission
            type: 'POST',
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type header
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Ensure CSRF token is passed
            },
            success: function (response) {
                // Handle success
                var messageDiv = $('#messageDiv');  // The div where the message will be shown

                if (response.success) {
                    // Reset the form
                    messageDiv.html('<div class="alert alert-success">' + response.message + '</div>');

                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        $('#assetRequestForm')[0].reset();
                        messageDiv.html(''); // Clear the message div
                        location.reload();
                    }, 5000);

                } else {
                    // Error message
                    messageDiv.html('<div class="alert alert-danger">Error: ' + response.message + '</div>');
                }

                // Re-enable submit button
                $('.btn-success').prop('disabled', false).text('Submit');
            },
            error: function (xhr, status, error) {
                // Handle error
                alert('An error occurred. Please try again.');

                // Re-enable submit button
                $('.btn-success').prop('disabled', false).text('Submit');
            }
        });
    });
});
// When an asset is selected
$('#asset').on('change', function () {
    // Get the selected option
    var selectedOption = $(this).find('option:selected');

    // Retrieve the asset limit from the data attribute
    var limit = selectedOption.data('limit');

    // Set the maximum limit value to the input field
    $('#maximum_limit').val(limit);
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


// approval js 
$('#approvalModal').on('show.bs.modal', function (event) {
var button = $(event.relatedTarget); // Button that triggered the modal
var assestsid = button.data('request-id');
var employeeId = button.data('employee-id');
var employeeName = button.data('employee-name');
var assetId = button.data('asset-id');
var reqAmt = button.data('req-amt');
var reqDate = button.data('req-date');
var reqAmtPerMonth = button.data('req-amt-per-month');
var modelName = button.data('model-name');
var companyName = button.data('company-name');
var dealerNumber = button.data('dealer-number');
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0');
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd;
var employeeIds = employeeId;


// Set values in the modal form fields
$('#assestsid').val(assestsid);
$('#employee_id').val(employeeId);
$('#employee_name').val(employeeName); // Display Employee Name
$('#asset_id').val(assetId);
$('#req_amt').val(reqAmt);
$('#approval_status').val('');
$('#remark').val('');
$('#reg_Date').val(reqDate);
$('#approval_date').val(today);  // Set the value of the input
$('#employeeId').val(employeeIds);  // Set the value of the input

});
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



