$(document).ready(function () {
 // Handle form submission
 $('#queryForm').on('submit', function (e) {
     e.preventDefault(); // Prevent the default form submission
     const url = $(this).attr('action'); // Form action URL

     $.ajax({
         url: url, // Form action URL
         type: 'POST',
         data: $(this).serialize(), // Serialize the form data

         success: function (response) {
             // Display success message
             $('#message').removeClass('alert-danger').addClass('alert-success').text('Form submitted successfully!').show();

             // Reset the form
             $('#queryForm')[0].reset();

             // Refresh the table body with updated data
             refreshQueryTable();

             // Optionally, hide the success message after 3 seconds
             setTimeout(function () {
                 $('#message').hide();
             }, 3000); // 3 seconds
         },
         error: function (xhr, status, error) {
             // Display error message
             $('#message').removeClass('alert-success').addClass('alert-danger').text('An error occurred: ' + error).show();

             // Optionally, hide the error message after 3 seconds
             setTimeout(function () {
                 $('#message').hide();
             }, 3000); // 3 seconds
         }
     });
 });
});

// Function to refresh the query list table body
function refreshQueryTable() {
 $.ajax({
     url: window.location.href, // Refresh the current page's content
     type: 'GET',
     success: function (response) {
         // Extract the new table body HTML from the response
         var newTableBody = $(response).find('#queryTableBody').html();

         // Replace the old table body with the new one
         $('#queryTableBody').html(newTableBody);

         // Rebind the star selection event after the table is refreshed
         rebindStarSelection();
     },
     error: function () {
         $('#message').removeClass('alert-success').addClass('alert-danger').text('Failed to refresh the table.').show();
     }
 });
}

// Rebind the star selection event after the table is refreshed
function rebindStarSelection() {
// Handle star click to select multiple stars
$('.star').on('click', function() {
   var queryId = $(this).data('query-id');  // Get the QueryId for the clicked star
   var rating = $(this).data('value');      // Get the value of the clicked star
   
   // Update the stars in the UI based on the clicked star
   $(this).siblings().removeClass('text-success').addClass('text-muted');
   $(this).prevAll().addClass('text-success');
   $(this).addClass('text-success');
   
   // Allow for the possibility of selecting multiple stars
   if ($(this).hasClass('text-muted')) {
       $(this).removeClass('text-muted').addClass('text-success');
   } else {
       $(this).addClass('text-muted').removeClass('text-success');
   }
   
   // Send the selected rating to the server via AJAX
   var selectedRating = 0;
   $(this).siblings().addBack().each(function() {
       if ($(this).hasClass('text-success')) {
           selectedRating++;
       }
   });
   
   // Send the selected rating to the server
   $.ajax({
       url: deptQueryUrl, 
       type: 'POST',
       data: {
           queryId: queryId,
           rating: selectedRating,
           _token: '{{ csrf_token() }}'  // Include CSRF token for security
       },
       success: function(response) {
           // Show success or error message above the table based on the response
           var message = response.message;
           var messageType = response.success ? 'success' : 'error';
   
           // Clear any previous messages
           $('#message-container').html('');
           $('#message-container').html('<div class="alert alert-' + messageType + '">' + message + '</div>');
   
           // Update the rating in the current row (if necessary)
           if (response.success) {
               // You could also update other elements here if needed
               // Just update the current row with the new rating
               updateRatingDisplay(queryId, selectedRating);
           }
   
           // Make the message disappear after 3 seconds
           setTimeout(function() {
               $('#message-container').html('');
           }, 3000); // 3 seconds delay
       },
       error: function(xhr, status, error) {
           // Handle AJAX error
           $('#message-container').html('<div class="alert alert-danger">An error occurred while updating the rating.</div>');
           setTimeout(function() {
               $('#message-container').html('');
           }, 3000); // 3 seconds delay
       }
   });
   });
   
}


   
   document.getElementById('Department_name').addEventListener('change', function () {
       var selectedDepartmentId = this.value; // Get selected department ID
       var subjectSelect = document.getElementById('Department_name_sub');
   
       // Clear current subjects
       subjectSelect.innerHTML = '<option value="" disabled selected>Select a Subject</option>';
   
       // Loop through all subject options
       var options = options; // Get subjects as a JSON array
       options.forEach(function (department_sub) {
           if (department_sub.DepartmentId == selectedDepartmentId) {
               var option = document.createElement('option');
               option.value = department_sub.DeptQSubject;
               option.text = department_sub.DeptQSubject;
               subjectSelect.appendChild(option);
           }
       });
   });
   
   $(document).ready(function () {
       // Fetch employee queries when the page loads or refreshes
       fetchEmployeeQueries();
   
       function fetchEmployeeQueries() {
           $.ajax({
               url: employeequery, // Define the route for employee-specific queries
               method: 'GET',
               success: function (response) {
                   if (response.length > 0) {
                       $('#employeeQueryTableBody').empty(); // Clear the employee-specific table body first
   
                       // Loop through each query and append to the table
                       $.each(response, function (index, query) {
                        var statusMap = {
                            0: "Open",
                            1: "In Progress",
                            2: "Reply",
                            3: "Closed",
                            4: "Forward"
                        };
                           var row = '<tr>' +
                               '<td>' + (index + 1) + '.</td>' +
                               '<td>' +
                               '<strong>Name:</strong> ' + query.Fname + ' ' + query.Sname + ' ' + query.Lname + '<br>' + // Combine Fname, Sname, Lname
                               '</td>' +
                               '<td>' +
                               '<strong>Subject:</strong> ' + query.QuerySubject + '<br>' +
                               '<strong>Subject Details:</strong> ' + query.QueryValue + '<br>' +
                               '<strong>Query to:</strong> ' + query.DepartmentName + '<br>' +
                               '</td>' +
                               '<td>' + (statusMap[query.Level_1QStatus] || 'N/A') + '</td>' +
                               '<td>' + (statusMap[query.Level_2QStatus] || 'N/A') + '</td>' +
                               '<td>' + (statusMap[query.Level_3QStatus] || 'N/A') + '</td>' +
                               '<td>' + (statusMap[query.Mngmt_QStatus] || 'N/A') + '</td>' +
                               '<td>' +
                               // Check if Level_1QStatus is 3 to disable the button
                               (query.QueryStatus_Emp == 3 ?
                                   '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Action</button>' :
                                   '<button class="btn btn-primary take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action</button>'
                               ) +
                               '</td>' +
                               '</tr>';
                           $('#employeeQueryTableBody').append(row);
                       });
   
                       // Attach event listener to the "Take Action" buttons
                       // Attach event listener to the "Take Action" buttons
                       $('.take-action-btn').on('click', function () {
                           var queryId = $(this).data('query-id');
   
                           var query = response.find(q => q.QueryId == queryId); // Find the query by ID
   
                           // Populate modal fields with query data
                           $('#querySubject').val(query.QuerySubject);
                           $('#querySubjectValue').val(query.QueryValue);
                           $('#queryName').val(query.Fname + ' ' + query.Sname + ' ' + query.Lname);
                           $('#queryDepartment').val(query.DepartmentName);
                           if (query.Level_1QStatus) {
                            $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                            } else if (query.Level_2QStatus) {
                                $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                            } else if (query.Level_3QStatus) {
                                $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                            }
                    
                        // Now, ensure the visibility of forward sections based on the selected status after setting it
                        toggleForwardSection($('#status').val());  // Reapply the visibility logic
                        if (query.Level_1QStatus === 3) {
                            $('#reply').val(query.Level_1ReplyAns).prop('readonly', true);  // Make read-only if Level 1 is closed
                        } else if (query.Level_2QStatus === 3) {
                            $('#reply').val(query.Level_2ReplyAns).prop('readonly', true);  // Make read-only if Level 2 is closed
                        } else if (query.Level_3QStatus === 3) {
                            $('#reply').val(query.Level_3ReplyAns).prop('readonly', true);  // Make read-only if Level 3 is closed
                        } else {
                            // If not closed, allow editing
                            $('#reply').prop('readonly', false);  // Make editable if the status is not closed
                        }  
                         // Disable the "Save Action" button if any of the Level statuses is 3 (Closed)
                            if (query.Level_1QStatus === 3 || query.Level_2QStatus === 3 || query.Level_3QStatus === 3) {
                                $('button[type="submit"]').prop('disabled', true);  // Disable the Save Action button
                            } else {
                                $('button[type="submit"]').prop('disabled', false);  // Enable the Save Action button if status is not closed
                            }                        
                            $('#forwardTo').empty(); // Clear the forwardTo dropdown
   
                           // Add the default option (value 0) for the "Forward To" dropdown
                           $('#forwardTo').append('<option value="0">Select a Forward To</option>');
   
                           // Fetch the DeptQSubject and AssignEmpId for the department and populate the "Forward To" dropdown
                           fetchDeptQuerySubForDepartment(queryId);
   
                           // Store query ID in the form
                           $('#queryActionForm').data('query-id', queryId);
   
                           // Show the modal
                           $('#actionModal').modal('show');
                       });
   
                   } else {
                       $('#noEmployeeQueriesMessage').show(); // If no queries are found
                       $('#employeeQueryTab').hide(); // Hide the Employee Query tab
                       $('#employeeQuerySection').hide(); // Hide the Employee Specific Query section
                   }
               },
               error: function () {
                   console.log("Error fetching employee-specific queries.");
               }
           });
       }
       function toggleForwardSection(status) {

        // Default state when no option is selected (empty state)
        if (status === '') {
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="3"]').show(); // Ensure "Closed" is visible
            $('#forwardSection').hide(); // Hide "Forward To" field
            $('#forwardReasonSection').hide(); // Hide "Forward Reason" field
        }
        
        // If "In Progress" (1) or "Reply" (2) is selected, hide "Forward" and show "Closed"
        else if (status == '1' || status == '2') {
            $('#replyremark').show(); // Hide "Forward To" field
            $('#status option[value="4"]').hide(); // Hide "Forward"
            $('#status option[value="3"]').show(); // Show "Closed"
            $('#forwardSection').hide(); // Hide "Forward To" field
            $('#forwardReasonSection').hide(); // Hide "Forward Reason" field
        }

        // If "Forward" is selected, show forward fields
        else if (status == '4') {
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="3"]').show(); // Ensure "Closed" is visible
            $('#forwardSection').show(); // Show "Forward To" field
            $('#forwardReasonSection').show(); // Show "Forward Reason" field
            $('#status option[value="1"]').hide(); // Ensure "inprogress" is hide
            $('#status option[value="2"]').hide(); // Ensure "reply" is hide
        }

        // If "Closed" is selected, hide forward fields
        else if (status == '3') {
            $('#forwardSection').hide();
            $('#forwardReasonSection').hide();
            $('#replyremark').show(); // Hide "Forward To" field
            $('#status option[value="1"]').hide(); // Ensure "inprogress" is hide
            $('#status option[value="2"]').hide(); // Ensure "reply" is hide
            $('#status option[value="4"]').hide(); // Ensure "Forward" is visible


        }
    }
   
       // Function to fetch DeptQSubject and AssignEmpId for a specific department and populate the "Forward To" dropdown
       function fetchDeptQuerySubForDepartment(queryid) {
           $.ajax({
               url: deptqueriesub, // Backend route to fetch DeptQSubject and AssignEmpId
               method: 'GET',
               data: { queryid: queryid },
               success: function (response) {
                   console.log(response); // To check the response structure
   
                   // Clear the dropdown before adding new items
                   $('#forwardTo').empty();
   
                   // Add the default option (value 0) for the "Forward To" dropdown
                   $('#forwardTo').append('<option value="0">Select a Forward To</option>');
   
                   if (response.length > 0) {
                       // Populate the "Forward To" dropdown with options
                       $.each(response, function (index, item) {
                           var option = $('<option></option>')
                               .attr('value', item.AssignEmpId) // Set the value to AssignEmpId
                               .data('deptqsubject', item.DeptQSubject) // Store DeptQSubject as data
                               .text(item.DeptQSubject); // Display DeptQSubject in the dropdown
                           $('#forwardTo').append(option);
                       });
                   } else {
                       alert('No query subjects found for this department.');
                   }
               },
               error: function () {
                   console.log("Error fetching department query subjects.");
               }
           });
       }
       // Handle form submission
       $('#queryActionForm').on('submit', function (e) {
           e.preventDefault(); // Prevent the default form submission
           var queryId = $(this).data('query-id');
   
           // Serialize the form data (this automatically includes the CSRF token)
           var formData = $(this).serialize();
           var selectedOption = $('#forwardTo option:selected');
           var deptQSubject = selectedOption.data('deptqsubject'); // Get DeptQSubject from the selected option
           var assignEmpId = selectedOption.val(); // Get AssignEmpId from the selected option
           var forwardReason = $('#forwardReason').val(); // Get Forward Reason value
           // Append the selected DeptQSubject and AssignEmpId to the form data
           formData += '&deptQSubject=' + deptQSubject + '&assignEmpId=' + assignEmpId + '&query_id=' + queryId + '&forwardReason=' + forwardReason;
   
           // Send the form data to the server via AJAX
           $.ajax({
               url: queryaction, // Route for your action handler
               method: 'POST',
               data: formData, // Send the serialized form data (includes CSRF token automatically)
               success: function (response) {
                   // Check if the response contains a success message
                   if (response.success) {
                       // Show success message above the form
                       $('#actionMessage')
                           .removeClass('alert-danger') // Remove any previous error class
                           .addClass('alert-success') // Add success class
                           .text(response.message) // Display the success message from server response
                           .show(); // Display the message
   
                       // Optionally, you can hide the modal after success
                       // $('#actionModal').modal('hide');
   
                       // Optionally, you can refresh the table or update the status here
                       // Example: $('#someTable').load(location.href + ' #someTable');
                   } else {
                       // Show error message if response indicates failure
                       $('#actionMessage')
                           .removeClass('alert-success') // Remove success class
                           .addClass('alert-danger') // Add error class
                           .text(response.message) // Display the failure message from server response
                           .show(); // Display the error message
                   }
               },
               error: function (xhr, status, error) {
                   console.log("Error saving action:", xhr.responseText);
   
                   // Show error message above the form in case of AJAX failure
                   $('#actionMessage')
                       .removeClass('alert-success') // Remove success class
                       .addClass('alert-danger') // Add error class
                       .text('An error occurred while saving the action. Please try again.') // Set error message
                       .show(); // Display error message
               }
           });
       });
   
   });
   // When the modal is hidden (i.e., closed), reset the form and any messages.
   
   $(document).ready(function () {
       $('#actionModal').on('hidden.bs.modal', function () {
           location.reload(); // Reloads the page when the modal is closed
       });
   });
   
   $(document).ready(function() {
   // Handle star click to select multiple stars
   $('.star').on('click', function() {
   var queryId = $(this).data('query-id');  // Get the QueryId for the clicked star
   var rating = $(this).data('value');      // Get the value of the clicked star
   
   // Update the stars in the UI based on the clicked star
   $(this).siblings().removeClass('text-success').addClass('text-muted');
   $(this).prevAll().addClass('text-success');
   $(this).addClass('text-success');
   
   // Allow for the possibility of selecting multiple stars
   if ($(this).hasClass('text-muted')) {
       $(this).removeClass('text-muted').addClass('text-success');
   } else {
       $(this).addClass('text-muted').removeClass('text-success');
   }
   
   // Send the selected rating to the server via AJAX
   var selectedRating = 0;
   $(this).siblings().addBack().each(function() {
       if ($(this).hasClass('text-success')) {
           selectedRating++;
       }
   });
   
   // Send the selected rating to the server
   $.ajax({
       url: deptQueryUrl,  // Your route for handling the rating update
       type: 'POST',
       data: {
           queryId: queryId,
           rating: selectedRating,
           _token: '{{ csrf_token() }}'  // Include CSRF token for security
       },
       success: function(response) {
           // Show success or error message above the table based on the response
           var message = response.message;
           var messageType = response.success ? 'success' : 'error';
   
           // Clear any previous messages
           $('#message-container').html('');
           $('#message-container').html('<div class="alert alert-' + messageType + '">' + message + '</div>');
   
           // Update the rating in the current row (if necessary)
           if (response.success) {
               // You could also update other elements here if needed
               // Just update the current row with the new rating
               updateRatingDisplay(queryId, selectedRating);
           }
   
           // Make the message disappear after 3 seconds
           setTimeout(function() {
               $('#message-container').html('');
           }, 3000); // 3 seconds delay
       },
       error: function(xhr, status, error) {
           // Handle AJAX error
           $('#message-container').html('<div class="alert alert-danger">An error occurred while updating the rating.</div>');
           setTimeout(function() {
               $('#message-container').html('');
           }, 3000); // 3 seconds delay
       }
   });
   });
   
 
 });
   
   // Function to update the rating display in the UI after the AJAX request
   function updateRatingDisplay(queryId, selectedRating) {
   // Find the row for the specific queryId
   var row = $('tr[data-query-id="' + queryId + '"]');
   
   // Update the star rating display for the row
   row.find('.star').each(function(index) {
   if (index < selectedRating) {
       $(this).removeClass('text-muted').addClass('text-success');
   } else {
       $(this).removeClass('text-success').addClass('text-muted');
   }
   });
   }

// Handle form submission via AJAX
$('#submitAction').on('click', function(e) {
 e.preventDefault(); // Prevent default form submission

 var actionStatus = $('#actionStatus').val();
 var actionRemark = $('#actionRemark').val();
 var rating = $('#rating').val(); // Corrected to get the value from the #rating dropdown
 var queryId = $('#actionQueryId').val();
 var csrfToken = $('input[name="_token"]').val(); // Get CSRF token
 
 // Submit the form data via AJAX
 $.ajax({
     url: '/submitAction', // Replace with actual URL
     method: 'POST',
     data: {
         _token: csrfToken, // Include CSRF token
         query_id: queryId,
         status: actionStatus,
         remark: actionRemark,
         rating: rating // Send the selected rating value
     },
     success: function(response) {
         // Target the message container and set the message content
         var messageContainer = $('#messageContainer'); // Assuming you have a div with this ID

         // Check if the response indicates success
         if (response.success) {
             messageContainer.html('<div class="alert alert-success">Query Updated successfully!</div>');
             messageContainer.show(); // Ensure the message container is visible
             $('#actionModalEmp')[0].reset();
               setTimeout(function() {
                         location.reload();
                     }, 3000);
         } else {
             messageContainer.html('<div class="alert alert-danger">Error submitting action!</div>');
             messageContainer.show(); // Ensure the message container is visible
         }
     },
     error: function() {
         // Handle unexpected errors (like network issues)
         var messageContainer = $('#messageContainer');
         messageContainer.html('<div class="alert alert-danger">Error submitting action!</div>');
         messageContainer.show(); // Show the error message
     }
 });
});

// Open the new action modal
$(document).on('change', '#actionStatus', function() {
 var status = $(this).val(); // Get the selected value from the dropdown
  console.log(status);
 // Check if the selected value is "Close" (value = 3)
 if (status == '3') {
     // Show the rating section when "Close" is selected
     $('#ratingSection').show();
 } else {
     // Hide the rating section for other values
     $('#ratingSection').hide();
 }
});

// Optional: If you want the rating to appear automatically when the modal opens based on the default or pre-selected value
$(document).on('click', '.take-action-emp-btn', function() {
    // Get the data attributes from the clicked button
    var queryId = $(this).data('query-id');
    var dataQueryStatus = $(this).data('query-status'); // Get the QueryStatus_Emp
    var dataQueryRemark = $(this).data('query-remark'); // Get the remark value
    
    // Hide the existing modal if open
    $('#actionModal').modal('hide');
    
    // Show the action modal
    $('#actionModalEmp').modal('show');
    
    // Set the query ID in the modal for later use
    $('#actionQueryId').val(queryId);
    
    // Reset the 'selected' attribute for all options (clear previous selections)
    $('#actionStatus').find('option').prop('selected', false);
    
    // Set the action status dropdown based on the data-query-status value
    if (dataQueryStatus) {
        $('#actionStatus').val(dataQueryStatus);  
    }
    
    // Set the action remark based on the data-query-remark value
    if (dataQueryRemark) {
        $('#actionRemark').val(dataQueryRemark);  // Set the remark text
    } else {
        $('#actionRemark').val('');  // Default to empty if no remark is provided
    }
    
    // Hide the rating section initially when modal is opened (if needed)
    $('#ratingSection').hide();
});




$(document).ready(function() {
    // Initial state on page load: No option selected, dropdown options visible
    toggleForwardSection($("#status").val()); // Initialize visibility of forward section based on the selected status (or default blank)
    // Listen for changes to the "Status" dropdown
    $('#status').on('change', function () {
        var statusValue = $(this).val();
        toggleForwardSection(statusValue); // Adjust UI based on selected status
    });

    // Function to toggle visibility of forward section based on selected status
    function toggleForwardSection(status) {
        console.log(status); // For debugging, you can remove this in production

        // Default state when no option is selected (empty state)
        if (status === '') {
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="3"]').show(); // Ensure "Closed" is visible
            $('#forwardSection').hide(); // Hide "Forward To" field
            $('#forwardReasonSection').hide(); // Hide "Forward Reason" field
        }
        
        // If "In Progress" (1) or "Reply" (2) is selected, hide "Forward" and show "Closed"
        else if (status == '1' || status == '2') {
            $('#replyremark').show(); // Hide "Forward To" field
            $('#status option[value="4"]').hide(); // Hide "Forward"
            $('#status option[value="3"]').show(); // Show "Closed"
            $('#forwardSection').hide(); // Hide "Forward To" field
            $('#forwardReasonSection').hide(); // Hide "Forward Reason" field
        }

        // If "Forward" is selected, show forward fields
        else if (status == '4') {
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="3"]').show(); // Ensure "Closed" is visible
            $('#forwardSection').show(); // Show "Forward To" field
            $('#forwardReasonSection').show(); // Show "Forward Reason" field
            $('#status option[value="1"]').hide(); // Ensure "Forward" is visible
            $('#status option[value="2"]').hide(); // Ensure "Closed" is visible
        }

        // If "Closed" is selected, hide forward fields
        else if (status == '3') {
            $('#forwardSection').hide();
            $('#forwardReasonSection').hide();
        }
    }
});

