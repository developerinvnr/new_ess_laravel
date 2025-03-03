$(document).ready(function () {
    // Fetch employee queries when the page loads or refreshes
    fetchEmployeeQueries();
    function fetchEmployeeQueries() {
        var isHodView = $("#hod-view").is(":checked"); // Get the checkbox state
        var valueToSend = isHodView ? "1" : "0"; // Send '1' for true, '0' for false

        $.ajax({
            url: getqueriesUrl, // Define the route for employee-specific queries
            method: "GET",
            data: { hod_view: valueToSend }, // Send the checkbox state as a parameter
            success: function (response) {
                if (response.length > 0) {
                    $("#employeeQueryTableBody").empty(); // Clear the employee-specific table body first

                    // Loop through each query and append to the table
                    $.each(response, function (index, query) {
                        var actionButton = "";
                        let queryDate = query.QueryDT ? new Date(query.QueryDT) : null; // Parse the date if available
                        let formattedDate = queryDate
                            ? queryDate.toLocaleDateString("en-GB", {
                                  // Format as dd-mm-yyyy
                                  day: "2-digit",
                                  month: "2-digit",
                                  year: "numeric",
                              })
                            : "N/A"; // Default to 'N/A' if the date is not available
                        // Check if any of the level fields match the employeeId
                        var showActionButton = [
                            query.Level_1ID,
                            query.Level_1QFwdEmpId,
                            query.Level_1QFwdEmpId2,
                            query.Level_1QFwdEmpId3,
                            query.Level_2ID,
                            query.Level_2QFwdEmpId,
                            query.Level_2QFwdEmpId2,
                            query.Level_2QFwdEmpId3,
                            query.Level_3ID,
                            query.Level_3QFwdEmpId,
                            query.Level_3QFwdEmpId2,
                            query.Level_3QFwdEmpId3,
                        ].includes(employeeId); // Checks if employeeId is present in any of the fields
                        // if (showActionButton) {
                        //     // Check if QueryStatus_Emp is 3, and disable the button if true
                        //     var actionButton = (query.QueryStatus_Emp == 3) ?
                        //         '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Action</button>' :
                        //         '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action</button>';
                        // }
                        if (showActionButton) {
                            // If showActionButton is true, create the action button
                            actionButton = '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action</button>';
                        }
                        var statusMap = {
                            0: "<b class='success'>Open</b>",
                            1: "<b class='warning'>In Progress</b>",
                            2: "<b class='info'>Reply</b>",
                            3: "<b class='deafult'>Closed</b>",
                            4: "<b class='danger'>Forward</b>",
                        };
                        var row =
                            "<tr>" +
                            "<td>" +
                            (index + 1) +
                            ".</td>" +
                            "<td>" +
                            // Condition to hide Name section
                            ((employeeId == query.HodId || employeeId == query.RepMgrId) && query.HideYesNo == "Y" ? "-" : "<strong></strong> " + query.Fname + " " + query.Lname + " " + query.Sname + "<br>") + // Show Name if condition is not met
                            "</td>" +
                            "<td>" +
                            formattedDate +
                            "</td>" +
                            "<td>" +
                            "<strong>Subject:</strong> " +
                            query.QuerySubject +
                            "<br>" +
                            "<strong>Subject Details:</strong> " +
                            query.QueryValue +
                            "<br>" +
                            "<strong>Query to:</strong> " +
                            query.department_name +
                            "<br>" +
                            "</td>" +
                            "<td>" +
                            (statusMap[query.QStatus] || "N/A") +
                            "</td>" +
                            "<td>" +
                            '<a href="#" data-bs-toggle="modal" data-bs-target="#viewqueryModal" class="viewquery" ' +
                            'data-employee-id="' +
                            query.EmployeeID +
                            '" ' +
                            'data-query-subject="' +
                            query.QueryValue +
                            '" ' +
                            'data-query-depsubject="' +
                            query.DeptQSubject +
                            '" ' +
                            'data-query-dt="' +
                            query.QueryDT +
                            '" ' +
                            'data-level-1-status="' +
                            query.Level_1QStatus +
                            '" ' +
                            'data-level-1-reply="' +
                            query.Level_1ReplyAns +
                            '" ' +
                            'data-level-1-date="' +
                            query.Level_1QToDT +
                            '" ' +
                            'data-level-2-status="' +
                            query.Level_2QStatus +
                            '" ' +
                            'data-level-2-reply="' +
                            query.Level_2ReplyAns +
                            '" ' +
                            'data-level-2-date="' +
                            query.Level_2QToDT +
                            '" ' +
                            'data-level-3-status="' +
                            query.Level_3QStatus +
                            '" ' +
                            'data-level-3-date="' +
                            query.Level_3QToDT +
                            '" ' +
                            'data-level-3-reply="' +
                            query.Level_3ReplyAns +
                            '" ' +
                            'data-department-name="' +
                            query.department_name +
                            '">View</a>' +
                            "</td>" +
                            "</tr>";
                        $("#employeeQueryTableBody").append(row);
                    });
                    
                    // Attach event listener to the "Take Action" buttons
                    $(".take-action-btn").on("click", function () {
                        var queryId = $(this).data("query-id");

                        var query = response.find((q) => q.QueryId == queryId); // Find the query by ID
                        // Check if any status is 'Forwarded' (status code 4)
                        if (query.Level_1QStatus === 4 || query.Level_2QStatus === 4 || query.Level_3QStatus === 4 || query.Mngmt_QStatus === 4) {
                            //    console.log('Forwarded status found, resetting the status field');

                            // Set status to 1 (or whatever value you want for forwarded status)
                            $("#status").val(""); // You can set this to whatever value makes sense in your case
                            //console.log('Form field "status" has been updated to "1" due to forwarded status');
                        } else {
                            // If not forwarded, populate the status based on available data
                            if (query.Level_1QStatus) {
                                //console.log('Setting status to Level 1: ' + query.Level_1QStatus);
                                $("#status").val(query.Level_1QStatus); // Display Level 1 Status
                            } else if (query.Level_2QStatus) {
                                //    console.log('Setting status to Level 2: ' + query.Level_2QStatus);
                                $("#status").val(query.Level_2QStatus); // Display Level 2 Status
                            } else if (query.Level_3QStatus) {
                                //    console.log('Setting status to Level 3: ' + query.Level_3QStatus);
                                $("#status").val(query.Level_3QStatus); // Display Level 3 Status
                            } else if (query.Mngmt_QStatus) {
                                //    console.log('Setting status to Management: ' + query.Mngmt_QStatus);
                                $("#status").val(query.Mngmt_QStatus); // Display Management Status
                            }
                        }
                        // Populate modal fields with query data
                        $("#querySubject").val(query.QuerySubject);
                        $("#querySubjectValue").val(query.QueryValue);
                        $("#queryName").val(query.Fname + " " + query.Sname + " " + query.Lname);
                        $("#queryDepartment").val(query.department_name);
                        //    if (query.Level_1QStatus) {
                        //     console.log('ass');
                        //     $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                        //     } else if (query.Level_2QStatus) {
                        //         $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                        //     } else if (query.Level_3QStatus) {
                        //         $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                        //     }

                        // Now, ensure the visibility of forward sections based on the selected status after setting it
                        toggleForwardSection($("#status").val()); // Reapply the visibility logic
                        if (query.Level_1QStatus === 3) {
                            $("#reply").val(query.Level_1ReplyAns).prop("readonly", true); // Make read-only if Level 1 is closed
                        } else if (query.Level_2QStatus === 3) {
                            $("#reply").val(query.Level_2ReplyAns).prop("readonly", true); // Make read-only if Level 2 is closed
                        } else if (query.Level_3QStatus === 3) {
                            $("#reply").val(query.Level_3ReplyAns).prop("readonly", true); // Make read-only if Level 3 is closed
                        } else {
                            // If not closed, allow editing
                            $("#reply").prop("readonly", false); // Make editable if the status is not closed
                        }
                        //    console.log(query.QueryStatus_Emp);
                        // Disable the "Save Action" button if any of the Level statuses is 3 (Closed)
                        if (query.Level_1QStatus === 3 || query.Level_2QStatus === 3 || query.Level_3QStatus === 3 || query.QueryStatus_Emp === 3) {
                            $('button[type="submit"]').prop("disabled", true); // Disable the Save Action button
                        }
                        if (query.QueryStatus_Emp === 0) {
                            $('button[type="submit"]').prop("disabled", false); // Disable the Save Action button
                        } else {
                            $('button[type="submit"]').prop("disabled", false); // Enable the Save Action button if status is not closed
                        }
                        $("#forwardTo").empty(); // Clear the forwardTo dropdown

                        // Add the default option (value 0) for the "Forward To" dropdown
                        $("#forwardTo").append('<option value="0">Select a Forward To</option>');

                        // Fetch the DeptQSubject and AssignEmpId for the department and populate the "Forward To" dropdown
                        fetchDeptQuerySubForDepartment(queryId);

                        // Store query ID in the form
                        $("#queryActionForm").data("query-id", queryId);

                        // Show the modal
                        $("#actionModal").modal("show");
                    });
                } else {
                    $("#noEmployeeQueriesMessage").show(); // If no queries are found
                    $("#employeeQueryTab").hide(); // Hide the Employee Query tab
                    $("#employeeQuerySection").hide(); // Hide the Employee Specific Query section
                }
            },
            error: function () {
                console.log("Error fetching employee-specific queries.");
            },
        });
    }
    $(document).on("change", "#hod-view", function () {
        fetchEmployeeQueries();
    });
    $("#status-loader").on("click", function () {
        $("#status").val(""); // Reset the status field

        // Set the "Select Option" as the default text for the dropdown
        $("#status option:first").prop("selected", true); // This will select the first option which is the "Select Status" text

        // Pass empty value to toggleForwardSection to reset visibility of related fields
        toggleForwardSection(""); // Call toggleForwardSection with empty value
    });
    function toggleForwardSection(status) {
        // Default state when no option is selected (empty state)
        if (status === "") {
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="1"]').show(); // Ensure "Closed" is visible
            $('#status option[value="2"]').show(); // Ensure "Closed" is visible
            $('#status option[value="3"]').hide(); // Ensure "Closed" is visible
        }

        // If "In Progress" (1) or "Reply" (2) is selected, hide "Forward" and show "Closed"
        else if (status == "1" || status == "2") {
            $("#replyremark").show(); // Hide "Forward To" field
            $('#status option[value="4"]').hide(); // Hide "Forward"
            $('#status option[value="3"]').show(); // Show "Closed"
            $("#forwardSection").hide(); // Hide "Forward To" field
            $("#forwardReasonSection").hide(); // Hide "Forward Reason" field
        }

        // If "Forward" is selected, show forward fields
        else if (status == "4") {
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="3"]').show(); // Ensure "Closed" is visible
            $("#forwardSection").show(); // Show "Forward To" field
            $("#forwardReasonSection").show(); // Show "Forward Reason" field
            $('#status option[value="1"]').hide(); // Ensure "inprogress" is hide
            $('#status option[value="2"]').hide(); // Ensure "reply" is hide
        }

        // If "Closed" is selected, hide forward fields
        else if (status == "3") {
            $("#forwardSection").hide();
            $("#forwardReasonSection").hide();
            $("#replyremark").show(); // Hide "Forward To" field
            $('#status option[value="1"]').hide(); // Ensure "inprogress" is hide
            $('#status option[value="2"]').hide(); // Ensure "reply" is hide
            $('#status option[value="4"]').hide(); // Ensure "Forward" is visible
        }
    }
    var statusMapp = {
        0: "Open",
        1: "In Process",
        2: "Reply",
        3: "Closed",
        4: "Escalate",
    };
    function formatDate(date) {
        // Check if the date is a default value (like '0000:00:00' or '1970')
        if (date === "0000:00:00" || date === "1970-01-01" || !date) {
            return "-"; // Return dash if it's one of the default values
        }

        // Format the date if it's valid
        const formattedDate = new Date(date);
        if (formattedDate.toString() === "Invalid Date") {
            return "-"; // Return dash if the date is invalid
        }

        // Format the date to dd/mm/yyyy
        const day = String(formattedDate.getDate()).padStart(2, "0");
        const month = String(formattedDate.getMonth() + 1).padStart(2, "0"); // Months are zero-indexed
        const year = formattedDate.getFullYear();

        return `${day}/${month}/${year}`;
    }
    $(document).on("click", ".viewquery", function () {
        // Get the dynamic data from the clicked query row
        var querySubject = $(this).data("query-subject");
        var querydepSubject = $(this).data("query-depsubject");
        var queryDetails = $(this).data("query-details");
        var queryRaiseDate = $(this).data("query-dt");
        var level1Status = $(this).data("level-1-status");
        var level1Remarks = $(this).data("level-1-reply");
        var level1Date = $(this).data("level-1-date");
        var level2Status = $(this).data("level-2-status");
        var level2Remarks = $(this).data("level-2-reply");
        var level2Date = $(this).data("level-2-date");
        var level3Status = $(this).data("level-3-status");
        var level3Remarks = $(this).data("level-3-reply");
        var level3Date = $(this).data("level-3-date");
        var department_name = $(this).data("department-name");
        // Map status code to string (e.g., 0 => "Open")
        queryRaiseDate = formatDate(queryRaiseDate);
        level1Date = formatDate(level1Date);
        level2Date = formatDate(level2Date);
        level3Date = formatDate(level3Date);

        level1Status = statusMapp[level1Status] || "N/A";
        level2Status = statusMapp[level2Status] || "N/A";
        level3Status = statusMapp[level3Status] || "N/A";
        // Populate the modal with the dynamic data
        $("#modalDept").text(department_name || "N/A");

        $("#modalSub").text(querydepSubject || "N/A");
        $("#modalQueryDetails").text(querySubject || "N/A");
        $("#modalRaiseDate").text(queryRaiseDate || "N/A");

        // Level 1
        $("#level1Status").text(level1Status || "N/A");
        $("#level1Remarks").text(level1Remarks || "N/A");
        $("#level1Date").text(level1Date || "N/A");

        // Level 2
        $("#level2Status").text(level2Status || "N/A");
        $("#level2Remarks").text(level2Remarks || "N/A");
        $("#level2Date").text(level2Date || "N/A");

        // Level 3
        $("#level3Status").text(level3Status || "N/A");
        $("#level3Remarks").text(level3Remarks || "N/A");
        $("#level3Date").text(level3Date || "N/A");
    });
    // Function to fetch DeptQSubject and AssignEmpId for a specific department and populate the "Forward To" dropdown
    function fetchDeptQuerySubForDepartment(queryid) {
        $.ajax({
            url: deptQueryUrl, // Backend route to fetch DeptQSubject and AssignEmpId
            method: "GET",
            data: { queryid: queryid },
            success: function (response) {
                // console.log(response); // To check the response structure

                // Clear the dropdown before adding new items
                $("#forwardTo").empty();

                // Add the default option (value 0) for the "Forward To" dropdown
                $("#forwardTo").append('<option value="0">Select a Forward To</option>');

                if (response.length > 0) {
                    // Populate the "Forward To" dropdown with options
                    $.each(response, function (index, item) {
                        var option = $("<option></option>")
                            .attr("value", item.AssignEmpId) // Set the value to AssignEmpId
                            .data("deptqsubject", item.DeptQSubject) // Store DeptQSubject as data
                            .text(item.DeptQSubject); // Display DeptQSubject in the dropdown
                        $("#forwardTo").append(option);
                    });
                } else {
                    alert("No query subjects found for this department.");
                }
            },
            error: function () {
                console.log("Error fetching department query subjects.");
            },
        });
    }
    // Handle form submission
    // Handle form submission
    $("#queryActionForm").on("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission
        var queryId = $(this).data("query-id");

        // Serialize the form data (this automatically includes the CSRF token)
        var formData = $(this).serialize();
        var selectedOption = $("#forwardTo option:selected");
        var deptQSubject = selectedOption.data("deptqsubject"); // Get DeptQSubject from the selected option
        var assignEmpId = selectedOption.val(); // Get AssignEmpId from the selected option
        var forwardReason = $("#forwardReason").val(); // Get Forward Reason value
        // Append the selected DeptQSubject and AssignEmpId to the form data
        formData += "&deptQSubject=" + deptQSubject + "&assignEmpId=" + assignEmpId + "&query_id=" + queryId + "&forwardReason=" + forwardReason;

        // Send the form data to the server via AJAX
        $.ajax({
            url: queryactionUrl, // Route for your action handler
            method: "POST",
            data: formData, // Send the serialized form data (includes CSRF token automatically)
            success: function (response) {
                // Check if the response contains a success message
                if (response.success) {
                    // Show success message above the form
                    $("#actionMessage")
                        .removeClass("alert-danger") // Remove any previous error class
                        .addClass("alert-success") // Add success class
                        .text(response.message) // Display the success message from server response
                        .show(); // Display the message

                    // Optionally, you can hide the modal after success
                    // $('#actionModal').modal('hide');

                    // Optionally, you can refresh the table or update the status here
                    // Example: $('#someTable').load(location.href + ' #someTable');
                } else {
                    // Show error message if response indicates failure
                    $("#actionMessage")
                        .removeClass("alert-success") // Remove success class
                        .addClass("alert-danger") // Add error class
                        .text(response.message) // Display the failure message from server response
                        .show(); // Display the error message
                }
            },
            error: function (xhr, status, error) {
                console.log("Error saving action:", xhr.responseText);

                // Show error message above the form in case of AJAX failure
                $("#actionMessage")
                    .removeClass("alert-success") // Remove success class
                    .addClass("alert-danger") // Add error class
                    .text("An error occurred while saving the action. Please try again.") // Set error message
                    .show(); // Display error message
            },
        });
    });
});
$(document).ready(function () {
    // Handle form submission with AJAX
    $("#assetRequestForm").submit(function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Prepare form data (including files)
        var formData = new FormData(this);

        // Show loader (optional, for better UX)
        $(".btn-success").prop("disabled", true).text("Submitting...");

        // Make AJAX request to submit the form
        $.ajax({
            url: asseststoreUrl, // Your Laravel route to handle the form submission
            type: "POST",
            data: formData,
            processData: false, // Don't process the data
            contentType: false, // Don't set content type header
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), // Ensure CSRF token is passed
            },
            success: function (response) {
                // Handle success
                var messageDiv = $("#messageDiv"); // The div where the message will be shown

                if (response.success) {
                    // Reset the form
                    messageDiv.html('<div class="alert alert-success">' + response.message + "</div>");

                    // Optionally, hide the success message after a few seconds (e.g., 3 seconds)
                    setTimeout(function () {
                        $("#assetRequestForm")[0].reset();
                        messageDiv.html(""); // Clear the message div
                        // location.reload();
                    }, 5000);
                } else {
                    // Error message
                    messageDiv.html('<div class="alert alert-danger">Error: ' + response.message + "</div>");
                }

                // Re-enable submit button
                $(".btn-success").prop("disabled", false).text("Submit");
            },
            error: function (xhr, status, error) {
                // Handle error
                alert("An error occurred. Please try again.");

                // Re-enable submit button
                $(".btn-success").prop("disabled", false).text("Submit");
            },
        });
    });
});
// When an asset is selected
$("#asset").on("change", function () {
    // Get the selected option
    var selectedOption = $(this).find("option:selected");

    // Retrieve the asset limit from the data attribute
    var limit = selectedOption.data("limit");

    // Set the maximum limit value to the input field
    $("#maximum_limit").val(limit);
});
$("#fileModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget);
    var fileUrl = button.data("file-url");
    var fileType = button.data("file-type");

    var filePreviewContainer = $("#filePreviewContainer");

    filePreviewContainer.empty();

    if (fileType === "bill" || fileType === "asset") {
        var imageElement = $("<img />", {
            src: fileUrl,
            class: "img-fluid",
            alt: "File preview",
        });

        filePreviewContainer.append(imageElement);
    } else {
        filePreviewContainer.append("<p>Unsupported file type</p>");
    }
});
$("#pdfModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var fileUrl = button.data("file-url"); // Extract file URL (PDF URL)

    var pdfCarouselContent = $("#pdfCarouselContent");
    var pdfCarousel = $("#pdfCarousel");

    pdfCarouselContent.empty(); // Clear carousel content

    // Hide carousel initially
    pdfCarousel.hide();

    // Load the PDF
    var loadingTask = pdfjsLib.getDocument(fileUrl);

    loadingTask.promise
        .then(function (pdf) {
            var totalPages = pdf.numPages;

            // Render all pages and add to the carousel
            for (var pageNum = 1; pageNum <= totalPages; pageNum++) {
                renderPage(pdf, pageNum);
            }

            // Show the carousel after rendering pages
            pdfCarousel.show();
        })
        .catch(function (error) {
            console.error("Error loading PDF: " + error);
            pdfCarouselContent.append("<p>Unable to load PDF</p>");
        });

    // Render a specific page of the PDF in the carousel
    function renderPage(pdf, pageNum) {
        pdf.getPage(pageNum).then(function (page) {
            // Set a fixed height of 500px for the PDF container
            var fixedHeight = 800;

            // Calculate scale based on fixed height (preserving aspect ratio)
            var scale = fixedHeight / page.getViewport({ scale: 1 }).height;

            var viewport = page.getViewport({ scale: scale });
            var canvas = document.createElement("canvas");
            var context = canvas.getContext("2d");
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Render the page
            page.render({ canvasContext: context, viewport: viewport }).promise.then(function () {
                // Add rendered page to carousel
                var isActive = pageNum === 1 ? "active" : ""; // First page is active
                var slide = $('<div class="carousel-item ' + isActive + '">').append(canvas);

                pdfCarouselContent.append(slide);
            });
        });
    }
});

// When the modal is shown, populate it with dynamic data
$("#assetdetails").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract data attributes from the button
    var requestDate = button.data("request-date");
    var assetType = button.data("asset-type");
    var price = button.data("price");
    var reqAmt = button.data("req-amt");
    var approvalAmt = button.data("approval-amt");
    var billCopy = button.data("bill-copy");
    var assetCopy = button.data("asset-copy");
    var identityRemark = button.data("identity-remark");

    // Populate the modal with the extracted data
    $("#modalRequestDate").text(requestDate);
    $("#modalAssetType").text(assetType);
    $("#modalPrice").text(price);
    $("#modalReqAmt").text(reqAmt);
    $("#modalApprovalAmt").text(approvalAmt);
    $("#modalIdentityRemark").text(identityRemark);

    // Update the modal image sources
    $("#modalBillCopy").attr("src", billCopy || ""); // if no bill copy, leave empty
    $("#modalAssetCopy").attr("src", assetCopy || ""); // if no asset copy, leave empty
});

// approval js
// $('#approvalModal').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget); // Button that triggered the modal

//     // Extract data from the button's data attributes
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

//     // Get today's date in YYYY-MM-DD format
//     var today = new Date();
//     var dd = String(today.getDate()).padStart(2, '0');
//     var mm = String(today.getMonth() + 1).padStart(2, '0');
//     var yyyy = today.getFullYear();
//     today = yyyy + '-' + mm + '-' + dd;

//     // Set the form fields in the modal
//     $('#assestsid').val(assestsid);
//     $('#employee_id').val(employeeId);
//     $('#employee_name').val(employeeName); // Display Employee Name
//     $('#asset_id').val(assetId);
//     $('#req_amt').val(reqAmt);
//     $('#reg_Date').val(reqDate);
//     $('#approval_date').val(today);  // Set today's date
//     $('#employeeId').val(employeeId);  // Set the Employee ID

//    // Reset the form fields first, before checking and displaying any data
// //    $('#approval_status').val('');  // Reset approval status dropdown to default
//    $('#remark').val('');  // Clear the remark field

//    // Handle Approval Status based on the role (HOD, IT, Accounts)
//    if (button.data('hod-approval-status') !== undefined) {
//        var hodApprovalStatus = button.data('hod-approval-status');
//        console.log(hodApprovalStatus);
//        // Set the value to 'approved' if 1, 'rejected' if 0
//        $('#approval_status').val(hodApprovalStatus === 1 ? '1' : '0');
//        $('#remark').val(button.data('hod-remark'));
//    } else if (button.data('it-approval-status') !== undefined) {
//        var itApprovalStatus = button.data('it-approval-status');
//        // Set the value to 'approved' if 1, 'rejected' if 0
//        $('#approval_status').val(itApprovalStatus === 1 ? '1' : '0');
//        $('#remark').val(button.data('it-remark'));
//    } else if (button.data('acc-approval-status') !== undefined) {
//        var accApprovalStatus = button.data('acc-approval-status');
//        // Set the value to 'approved' if 1, 'rejected' if 0
//        $('#approval_status').val(accApprovalStatus === 1 ? '1' : '0');
//        $('#remark').val(button.data('acc-remark'));
//    } else {
//        // If no approval status data is found, both fields will remain empty
//        $('#approval_status').val('');  // Reset to default if no status
//        $('#remark').val('');
//    }
// });
$("#approvalModal").on("show.bs.modal", function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract data from the button's data attributes
    var assestsid = button.data("request-id");
    var employeeId = button.data("employee-id");
    var employeeName = button.data("employee-name");
    var assetId = button.data("asset-id");
    var reqAmt = button.data("req-amt");
    var reqDate = button.data("req-date");

    // Get today's date in YYYY-MM-DD format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, "0");
    var mm = String(today.getMonth() + 1).padStart(2, "0");
    var yyyy = today.getFullYear();
    today = yyyy + "-" + mm + "-" + dd;

    // Set the values in the form fields
    // $('#assestsid').val(assestsid);
    $("#employee_id").val(employeeId);
    $("#employee_name").val(employeeName); // For hidden input
    $("#employee_name_span").text(employeeName); // Display Employee Name in span
    $("#asset_id").val(assetId); // For hidden input
    $("#asset_id_span").text(assetId); // Display Asset ID in span
    $("#req_amt").val(reqAmt); // For hidden input
    $("#req_amt_span").text(reqAmt); // Display Request Amount in span
    $("#reg_Date").val(reqDate); // For hidden input
    $("#reg_Date_span").text(reqDate); // Display Reg Date in span
    $("#approval_date").val(today); // Set today's date
    $("#employeeId").val(employeeId); // Set the Employee ID

    // Reset the form fields first, before checking and displaying any data
    $("#approval_status").val(""); // Reset approval status dropdown to default
    $("#remark").val(""); // Clear the remark field

    // Handle Approval Status based on the role (HOD, IT, Accounts)
    if (button.data("hod-approval-status") !== undefined) {
        var hodApprovalStatus = button.data("hod-approval-status");
        // Set the value to 'approved' if 1, 'rejected' if 0
        $("#approval_status").val(hodApprovalStatus === 1 ? "1" : "0");
        $("#remark").val(button.data("hod-remark"));
    } else if (button.data("it-approval-status") !== undefined) {
        var itApprovalStatus = button.data("it-approval-status");
        // Set the value to 'approved' if 1, 'rejected' if 0
        $("#approval_status").val(itApprovalStatus === 1 ? "1" : "0");
        $("#remark").val(button.data("it-remark"));
    } else if (button.data("acc-approval-status") !== undefined) {
        var accApprovalStatus = button.data("acc-approval-status");
        // Set the value to 'approved' if 1, 'rejected' if 0
        $("#approval_status").val(accApprovalStatus === 1 ? "1" : "0");
        $("#remark").val(button.data("acc-remark"));
    } else {
        // If no approval status data is found, both fields will remain empty
        $("#approval_status").val(""); // Reset to default if no status
        $("#remark").val("");
    }
});

// $('#approvalModal').on('show.bs.modal', function (event) {
// var button = $(event.relatedTarget); // Button that triggered the modal
// console.log(button.data('status'));
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
document.addEventListener("DOMContentLoaded", function () {
    // Show the first approval status by default
    const firstRequestId = document.querySelector(".btn-outline.success-outline.sm-btn")?.getAttribute("data-request-id");
    if (firstRequestId) {
        showApprovalStatus(firstRequestId); // Show the first request's approval section
    }

    // Attach click event listener to all View buttons
    const viewButtons = document.querySelectorAll(".btn-outline.success-outline.sm-btn");

    viewButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const requestId = this.getAttribute("data-request-id");
            showApprovalStatus(requestId);
        });
    });

    // Function to show only the relevant approval status
    function showApprovalStatus(requestId) {
        // Hide all approval sections first
        const allApprovalSections = document.querySelectorAll(".exp-details-box");
        allApprovalSections.forEach((section) => {
            section.style.display = "none";
        });

        // Show the approval section related to the clicked request
        const approvalSectionHOD = document.getElementById("approvalhod-" + requestId);
        if (approvalSectionHOD) {
            approvalSectionHOD.style.display = "block";
        }
        const approvalSectionIT = document.getElementById("approvalit-" + requestId);
        if (approvalSectionIT) {
            approvalSectionIT.style.display = "block";
        }
        const approvalSectionACCT = document.getElementById("approvalacct-" + requestId);
        if (approvalSectionACCT) {
            approvalSectionACCT.style.display = "block";
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    function validatePhoneNumber() {
        var phoneInput = document.getElementById("dealer_contact");
        var errorMessage = document.getElementById("phoneError");
        var phoneValue = phoneInput.value;
        console.log(phoneValue);

        // Check if the input is either 10 or 12 digits long
        var phoneRegex = /^\d{10}$|^\d{12}$/; // matches 10 or 12 digit numbers

        if (!phoneRegex.test(phoneValue)) {
            // Show error message if input is invalid
            errorMessage.style.display = "block";
            phoneInput.classList.add("is-invalid"); // Optionally add a red border
        } else {
            // Hide error message if input is valid
            errorMessage.style.display = "none";
            phoneInput.classList.remove("is-invalid");
        }
    }

    // Form submit event listener
    const form = document.querySelector("form");
    form.addEventListener("submit", function (event) {
        let isValid = true;

        // Validate required fields and custom checks
        const requiredFields = form.querySelectorAll("input[required], select[required], textarea[required]");

        // Loop through all required fields
        requiredFields.forEach(function (field) {
            // Check if field is empty or invalid
            if (!field.checkValidity()) {
                isValid = false;
                field.classList.add("is-invalid");
                field.classList.remove("is-valid");
            } else {
                field.classList.remove("is-invalid");
                field.classList.add("is-valid");
            }

            // Custom validation for phone number
            if (field.id === "dealer_contact") {
                validatePhoneNumber(); // Check phone number
            }
        });

        // If the form is not valid, prevent submission and show an alert
        if (!isValid) {
            event.preventDefault();
            alert("Please fill in all required fields correctly before submitting.");
        }
    });

    // Add input event listeners to validate phone number dynamically as user types
    const dealerContactField = document.getElementById("dealer_contact");
    if (dealerContactField) {
        dealerContactField.addEventListener("input", validatePhoneNumber);
    }
});
document.addEventListener("DOMContentLoaded", function () {
    // Assuming employeeChain is the PHP data passed to JavaScript as a JSON object
    const employeeChainData = employeeChainDatatojs; // The PHP data passed to JS

    // Step 1: Ensure RepEmployeeID is handled properly (validating relationships)
    const employeeIds = new Set(employeeChainData.map((d) => d.EmployeeID));

    const formattedData = employeeChainData.map((d) => {
        return {
            ...d,
            RepEmployeeID: employeeIds.has(d.RepEmployeeID) ? d.RepEmployeeID : null, // Only valid RepEmployeeID
        };
    });

    // Step 2: Extract distinct levels from the employee data, excluding level 0
    const levels = [...new Set(employeeChainData.map((d) => d.level))].filter((level) => level > 0); // Exclude level 0

    // Step 3: Populate the level dropdown dynamically
    const levelSelect = document.getElementById("levelSelect");
    levels.forEach((level) => {
        const option = document.createElement("option");
        option.value = level;
        option.textContent = `Level ${level}`;
        levelSelect.appendChild(option);
    });

    // Default to show data for level 1
    levelSelect.value = "1";
    renderTreeData(3); // Initially render tree data for level 1

    // Step 4: Add an event listener to handle the level change
    levelSelect.addEventListener("change", function () {
        const selectedLevel = parseInt(levelSelect.value);
        renderTreeData(selectedLevel); // Re-render the tree based on the selected level
    });

    // Step 5: Function to render the tree based on the selected level
    function renderTreeData(level) {
        // Filter data for the selected level
        const filteredData = formattedData.filter((d) => d.level <= level);

        // Clear existing tree content
        d3.select("#employeeTreeContainer").select("svg").remove();

        // Set a fixed width for the tree and max height for scrolling
        const width = 1200;
        const maxHeight = 700;
        const height = Math.min(filteredData.length * 220, maxHeight); // Limit height based on the number of nodes

        // Create a scrollable container for the tree
        d3.select("#employeeTreeContainer")
            .style("width", width + "px")
            .style("height", maxHeight + "px")
            .style("overflow-y", "auto") // Enable vertical scrolling for the whole tree
            .style("border", "1px solid #ddd"); // Optional: add a border for visibility

        // Set up the tree layout
        const treeLayout = d3.tree().size([width - 100, height - 200]);

        // Convert the employee data into a hierarchical structure using d3.stratify
        const root = d3
            .stratify()
            .id((d) => d.EmployeeID)
            .parentId((d) => d.RepEmployeeID)(filteredData);

        // Generate the tree data
        const treeData = treeLayout(root);

        // Append the SVG element to the container
        const svg = d3.select("#employeeTreeContainer").append("svg").attr("width", width).attr("height", height).append("g").attr("transform", `translate(50,70)`);

        // Links (connecting lines between parent and child nodes)
        svg.selectAll(".link")
            .data(treeData.links())
            .enter()
            .append("line")
            .attr("class", "link")
            .attr("x1", (d) => d.source.x)
            .attr("y1", (d) => d.source.y)
            .attr("x2", (d) => d.target.x)
            .attr("y2", (d) => d.target.y)
            .attr("stroke", "#a5cccd")
            .attr("stroke-width", 1) // Make the line thinner
            .attr("opacity", 0.6); // Set lower opacity to make the lines less prominent

        // Nodes (employee nodes)
        const nodes = svg
            .selectAll(".node")
            .data(treeData.descendants())
            .enter()
            .append("g")
            .attr("class", "node")
            .attr("transform", (d) => `translate(${d.x},${d.y})`);

        // Append rectangle boxes for each node (Width = 150, Height = 100)
        nodes.append("rect").attr("x", -75).attr("y", -50).attr("width", 150).attr("height", 140).attr("rx", 10).attr("ry", 10).style("fill", "#a5cccd").style("stroke", "#2980b9").style("stroke-width", 2);

        // Append a circle behind the text for the employee's first letter
        nodes
            .append("a")
            .attr("href", "javascript:void(0);")
            .attr("class", "user-info")
            .append("circle")
            .attr("r", 20) // Adjust the radius to fit the letter
            .attr("fill", "#2980b9") // Circle color
            .attr("stroke", "#ffffff") // Border color
            .attr("stroke-width", 2)
            .attr("cy", -25); // Position the circle at the top

        // Append the first letter of the employee's first name inside the circle
        nodes
            .append("text")
            .attr("x", 0) // Center the letter horizontally
            .attr("y", -25) // Center the letter vertically inside the circle
            .attr("dy", ".35em") // Vertically center the text
            .attr("text-anchor", "middle")
            .style("font-size", "18px") // Adjust font size to fit in circle
            .style("font-weight", "bold")
            .style("fill", "white")
            .text((d) => d.data.Fname.charAt(0)); // Display the first letter of Fname

        // Add a scrollable container for the employee's name, designation, and grade value inside the rectangle
        const foreignObject = nodes
            .append("foreignObject")
            .attr("x", -75) // Position inside rectangle
            .attr("y", 10) // Place below the circle
            .attr("width", 150)
            .attr("height", 100) // Adjust total height for all sections
            .style("overflow", "hidden"); // Prevent overflow of foreignObject

        // Add employee full name
        foreignObject
            .append("xhtml:div")
            .style("width", "150px")
            .style("overflow-y", "auto") // Enable vertical scrolling for name
            .style("font-size", "12px")
            .style("color", "#333")
            .style("text-align", "center")
            .style("font-weight", "bold")
            .html(function (d) {
                return d.data.Fname + " " + d.data.Sname + " " + d.data.Lname; // Display full name
            });

        // Add employee designation
        foreignObject
            .append("xhtml:div")
            .style("width", "150px")
            .style("overflow-y", "auto") // Enable vertical scrolling for designation
            .style("font-size", "12px")
            .style("color", "#333")
            .style("text-align", "center")
            .style("font-weight", "bold")
            .html(function (d) {
                return d.data.DesigName; // Display designation name
            });

        // Add employee grade
        foreignObject
            .append("xhtml:div")
            .style("width", "150px")
            .style("height", "40px") // Allocate space for grade
            .style("overflow-y", "auto") // Enable vertical scrolling for grade
            .style("font-size", "12px")
            .style("color", "#333")
            .style("text-align", "center")
            .style("font-weight", "bold")
            .html(function (d) {
                return d.data.Grade; // Display grade value
            });
    }
});

// document.addEventListener('DOMContentLoaded', function() {
//     // Dynamically passed employee data (e.g., from PHP)
//     const employeeChainData = employeeChainDatatojs; // This will contain the PHP data as a JavaScript object
//     // Step 1: Ensure RepEmployeeID is handled properly
//     const employeeIds = new Set(employeeChainData.map(d => d.EmployeeID));  // Set of all valid EmployeeID
//     console.log(employeeChainData);

//     const formattedData = employeeChainData.map(d => {
//         // Check if RepEmployeeID exists in the dataset. If not, set it to null
//         return {
//             ...d,
//             RepEmployeeID: employeeIds.has(d.RepEmployeeID) ? d.RepEmployeeID : null  // Only keep valid RepEmployeeID
//         };
//     });

//     // Step 2: Extract distinct levels from the employee data
//     const levels = [...new Set(employeeChainData.map(d => d.level))]; // Extract unique levels

//     // Step 3: Populate the level dropdown dynamically
//     const levelSelect = document.getElementById("levelSelect");
//     levels.forEach(level => {
//         const option = document.createElement("option");
//         option.value = level;
//         option.textContent = `Level ${level}`;
//         levelSelect.appendChild(option);
//     });

//     // Default to show data for level 1 (or whatever the default is)
//     levelSelect.value = "4"; // Change this as per your requirement
//     renderTreeData(4);  // Initially render level 1 tree

//     // Step 4: Add an event listener to handle the level change
//     levelSelect.addEventListener("change", function() {
//         const selectedLevel = parseInt(levelSelect.value);  // Get the selected level
//         renderTreeData(selectedLevel);  // Re-render the tree based on the selected level
//     });
//     // // Step 5: Function to render the tree based on the selected level
//     function renderTreeData(level) {
//         // Filter data for the selected level
//         const filteredData = formattedData.filter(d => d.level <= level);  // Filter by the selected level

//         // Clear existing tree content
//         d3.select("#employeeTreeContainer").select("svg").remove();  // Remove previous tree (if any)
//         console.log(filteredData);

//         // Set a fixed height for the tree (e.g., max height of 600px)
//         const width = 1200;
//         const maxHeight = 600;  // Set a max height for the tree
//         const height = Math.min(filteredData.length * 120, maxHeight); // Dynamically adjust height, but limit it

//         const treeLayout = d3.tree().size([width - 100, height - 100]);  // Adjusted size for vertical layout

//         //Convert the employee data into a hierarchical structure using d3.stratify
//         const root = d3.stratify()
//             .id(d => d.EmployeeID)
//             .parentId(d => d.RepEmployeeID)  // Use RepEmployeeID, which is now guaranteed to be valid or null
//             (filteredData);
//         // filteredData.forEach(d => {
//         //     // Ensure RepEmployeeID is null or valid
//         //     if (!d.RepEmployeeID) {
//         //         d.RepEmployeeID = null;  // Explicitly set RepEmployeeID to null for root nodes
//         //     }
//         // });

//         // // Apply D3 stratify method to create a hierarchical structure
//         // const root = d3.stratify()
//         //     .id(d => d.employeeId)      // Each node's unique ID
//         //     .parentId(d => d.RepEmployeeID)  // Ensure the parent relationship is handled
//         //     (filteredData);

//         // console.log(root);  // This will print the hierarchical structure, including root nodes

//         // Generate the tree data
//         const treeData = treeLayout(root);

//         // Append the SVG element to the container
//         const svg = d3.select("#employeeTreeContainer")
//             .append("svg")
//             .attr("width", width)
//             .attr("height", height)
//             .append("g")
//             .attr("transform", `translate(50,90)`);  // Add margin for better positioning

//         // Links (connecting lines between parent and child nodes)
//         svg.selectAll(".link")
//             .data(treeData.links())
//             .enter()
//             .append("line")
//             .attr("class", "link")
//             .attr("x1", d => d.source.x)  // Use 'x' for horizontal position
//             .attr("y1", d => d.source.y)  // Use 'y' for vertical position
//             .attr("x2", d => d.target.x)
//             .attr("y2", d => d.target.y)
//             .attr("stroke", "#a5cccd")
//             .attr("stroke-width", 2);

//         // Nodes (employee nodes)
//         const nodes = svg.selectAll(".node")
//             .data(treeData.descendants())
//             .enter()
//             .append("g")
//             .attr("class", "node")
//             .attr("transform", d => `translate(${d.x},${d.y})`);  // Use 'x' and 'y' for node position

//         // Append rectangle boxes for each node (Width = 150, Height = 100)
//         nodes.append("rect")
//             .attr("x", -75) // Center the box horizontally (150/2 = 75)
//             .attr("y", -50)  // Center the box vertically (100/2 = 50) -> Make sure it's not cut off
//             .attr("width", 150) // Width of the box
//             .attr("height", 100) // Height of the box
//             .attr("rx", 10) // Rounded corners
//             .attr("ry", 10) // Rounded corners
//             .style("fill", "#a5cccd") // Background color
//             .style("stroke", "#2980b9") // Border color
//             .style("stroke-width", 2);

//         // Append a circle behind the image for the employee avatar (background circle)
//         nodes.append("a")
//             .attr("href", "javascript:void(0);")
//             .attr("class", "user-info")
//             .append("circle") // Create a circle to be the background of the image
//             .attr("cx", 0) // Position the center horizontally at 0 (middle of the box)
//             .attr("cy", -40) // Position the center vertically above the name
//             .attr("r", 20) // Radius of the circle (since the image is 40x40, we set it to half)
//             .style("fill", "#75a9ab") // Set the background color to #75a9ab
//             .style("stroke", "#2980b9") // Optional: Add a border color if needed
//             .style("stroke-width", 2); // Optional: Border width for the circle

//         // Append the first letter inside the circle (initials)
//         nodes.append("text") // Add text element to display the first letter
//             .attr("x", 0) // Position horizontally at the center
//             .attr("y", -40) // Position vertically at the center of the circle
//             .attr("text-anchor", "middle") // Align the text in the middle
//             .attr("dominant-baseline", "middle") // Vertically align the text in the center
//             .style("font-size", "18px") // Set the font size to fit inside the circle
//             .style("font-weight", "bold") // Make the first letter bold
//             .style("fill", "#fff") // Set the text color to white
//             .text(d => d.data.Fname.charAt(0)); // Use the first letter of the first name

//         // Function to generate dynamic abbreviation based on first letter of each word
//         const getDynamicAbbreviation = (designation) => {
//             // Split the designation by space and get the first letter of each word
//             return designation.split(' ')
//                               .map(word => word.charAt(0).toUpperCase()) // Get first letter of each word and convert to uppercase
//                               .join(''); // Join the letters to form the abbreviation
//         };

//         // Append text labels for each node (Name)
//         nodes.append("text")
//             .attr("dy", 15) // Position the name text below the image (centered)
//             .attr("text-anchor", "middle")
//             .style("font-size", "12px")
//             .style("font-weight", "bold")
//             .style("fill", "#0a0a0a") // Text color (white for contrast)
//             .text(d => `${d.data.Fname} ${d.data.Lname}`);

//         // Append dynamic abbreviated designation text (Position it in the middle of the box)
//         nodes.append("text")
//             .attr("dy", 30) // Position below the name text
//             .attr("text-anchor", "middle")
//             .style("font-size", "10px")
//             .style("fill", "#0a0a0a") // Text color (white for contrast)
//             .text(d => d.data.DesigName ? getDynamicAbbreviation(d.data.DesigName) : ""); // Only append abbreviation if DesigName exists, otherwise append empty string

//         // Step 6: Enable scrolling after the tree is rendered
//         const treeContainer = document.getElementById("employeeTreeContainer");

//         // Check if the content exceeds the container's height
//         if (treeContainer.scrollHeight > treeContainer.clientHeight) {
//             // Enable smooth scrolling behavior dynamically
//             treeContainer.style.overflowY = 'auto';  // Allow vertical scrolling
//             treeContainer.style.scrollBehavior = 'smooth';  // Apply smooth scrolling
//         }
//     }

//     // Step 5: Function to render the tree based on the selected level
//     // function renderTreeData(level) {
//     //     // Filter data for the selected level
//     //     const filteredData = formattedData.filter(d => d.level <= level);  // Filter by the selected level

//     //     // Clear existing tree content
//     //     d3.select("#employeeTreeContainer").select("svg").remove();  // Remove previous tree (if any)

//     //     // Set up the dimensions of the tree
//     //     const width = 1200;
//     //     const height = filteredData.length * 120; // Adjust the height based on the number of nodes to prevent clipping

//     //     const treeLayout = d3.tree().size([width - 100, height - 100]);  // Adjusted size for vertical layout

//     //     // Convert the employee data into a hierarchical structure using d3.stratify
//     //     // const root = d3.stratify()
//     //     //     .id(d => d.EmployeeID)
//     //     //     .parentId(d => d.RepEmployeeID)  // Use RepEmployeeID, which is now guaranteed to be valid or null
//     //     //     (filteredData);
//     //     //     console.log(d.RepEmployeeID);
//     //     // Ensure the filtered data is ready and valid
//     //         filteredData.forEach(d => {
//     //             // Ensure RepEmployeeID is null or valid
//     //             if (!d.RepEmployeeID) {
//     //                 d.RepEmployeeID = null;  // Explicitly set RepEmployeeID to null for root nodes
//     //             }
//     //         });

//     //         // Apply D3 stratify method to create a hierarchical structure
//     //         const root = d3.stratify()
//     //             .id(d => d.EmployeeID)      // Each node's unique ID
//     //             .parentId(d => d.RepEmployeeID)  // Ensure the parent relationship is handled
//     //             (filteredData);

//     //         console.log(root);  // This will print the hierarchical structure, including root nodes

//     //     // Generate the tree data
//     //     const treeData = treeLayout(root);

//     //     // Append the SVG element to the container
//     //     const svg = d3.select("#employeeTreeContainer")
//     //         .append("svg")
//     //         .attr("width", width)
//     //         .attr("height", height)
//     //         .append("g")
//     //         .attr("transform", `translate(50,90)`);  // Add margin for better positioning

//     //     // Links (connecting lines between parent and child nodes)
//     //     svg.selectAll(".link")
//     //         .data(treeData.links())
//     //         .enter()
//     //         .append("line")
//     //         .attr("class", "link")
//     //         .attr("x1", d => d.source.x)  // Use 'x' for horizontal position
//     //         .attr("y1", d => d.source.y)  // Use 'y' for vertical position
//     //         .attr("x2", d => d.target.x)
//     //         .attr("y2", d => d.target.y)
//     //         .attr("stroke", "#a5cccd")
//     //         .attr("stroke-width", 2);

//     //     // Nodes (employee nodes)
//     //     const nodes = svg.selectAll(".node")
//     //         .data(treeData.descendants())
//     //         .enter()
//     //         .append("g")
//     //         .attr("class", "node")
//     //         .attr("transform", d => `translate(${d.x},${d.y})`);  // Use 'x' and 'y' for node position

//     //     // Append rectangle boxes for each node (Width = 150, Height = 100)
//     //     nodes.append("rect")
//     //         .attr("x", -75) // Center the box horizontally (150/2 = 75)
//     //         .attr("y", -50)  // Center the box vertically (100/2 = 50) -> Make sure it's not cut off
//     //         .attr("width", 150) // Width of the box
//     //         .attr("height", 100) // Height of the box
//     //         .attr("rx", 10) // Rounded corners
//     //         .attr("ry", 10) // Rounded corners
//     //         .style("fill", "#a5cccd") // Background color
//     //         .style("stroke", "#2980b9") // Border color
//     //         .style("stroke-width", 2);

//     //     // Append a circle behind the image for the employee avatar (background circle)
//     //     nodes.append("a")
//     //         .attr("href", "javascript:void(0);")
//     //         .attr("class", "user-info")
//     //         .append("circle") // Create a circle to be the background of the image
//     //         .attr("cx", 0) // Position the center horizontally at 0 (middle of the box)
//     //         .attr("cy", -40) // Position the center vertically above the name
//     //         .attr("r", 20) // Radius of the circle (since the image is 40x40, we set it to half)
//     //         .style("fill", "#75a9ab") // Set the background color to #75a9ab
//     //         .style("stroke", "#2980b9") // Optional: Add a border color if needed
//     //         .style("stroke-width", 2); // Optional: Border width for the circle

//     //     // Append the first letter inside the circle (initials)
//     //     nodes.append("text") // Add text element to display the first letter
//     //         .attr("x", 0) // Position horizontally at the center
//     //         .attr("y", -40) // Position vertically at the center of the circle
//     //         .attr("text-anchor", "middle") // Align the text in the middle
//     //         .attr("dominant-baseline", "middle") // Vertically align the text in the center
//     //         .style("font-size", "18px") // Set the font size to fit inside the circle
//     //         .style("font-weight", "bold") // Make the first letter bold
//     //         .style("fill", "#fff") // Set the text color to white
//     //         .text(d => d.data.Fname.charAt(0)); // Use the first letter of the first name

//     //     // Function to generate dynamic abbreviation based on first letter of each word
//     //     const getDynamicAbbreviation = (designation) => {
//     //         // Split the designation by space and get the first letter of each word
//     //         return designation.split(' ')
//     //                           .map(word => word.charAt(0).toUpperCase()) // Get first letter of each word and convert to uppercase
//     //                           .join(''); // Join the letters to form the abbreviation
//     //     };

//     //     // Append text labels for each node (Name)
//     //     nodes.append("text")
//     //         .attr("dy", 15) // Position the name text below the image (centered)
//     //         .attr("text-anchor", "middle")
//     //         .style("font-size", "12px")
//     //         .style("font-weight", "bold")
//     //         .style("fill", "#0a0a0a") // Text color (white for contrast)
//     //         .text(d => `${d.data.Fname} ${d.data.Lname}`);

//     //     // Append dynamic abbreviated designation text (Position it in the middle of the box)
//     //     nodes.append("text")
//     //         .attr("dy", 30) // Position below the name text
//     //         .attr("text-anchor", "middle")
//     //         .style("font-size", "10px")
//     //         .style("fill", "#0a0a0a") // Text color (white for contrast)
//     //         .text(d => d.data.DesigName ? getDynamicAbbreviation(d.data.DesigName) : ""); // Only append abbreviation if DesigName exists, otherwise append empty string
//     // }
// });
