$(document).ready(function () {

 // Handle form submission
//  $('#queryForm').on('submit', function (e) {
//      e.preventDefault(); // Prevent the default form submission
//      const url = $(this).attr('action'); // Form action URL
//      console.log('sdfsdfsdf');return;

//      $.ajax({
//          url: url, // Form action URL
//          type: 'POST',
//          data: $(this).serialize(), // Serialize the form data

//          success: function (response) {
//              // Display success message
//              $('#message').removeClass('alert-danger').addClass('alert-success').text('Form submitted successfully!').show();

//              // Reset the form
//              $('#queryForm')[0].reset();

//              // Refresh the table body with updated data
//              refreshQueryTable();

//              // Optionally, hide the success message after 3 seconds
//              setTimeout(function () {
//                  $('#message').hide();
//              }, 3000); // 3 seconds
//          },
//          error: function (xhr, status, error) {
//              // Display error message
//              $('#message').removeClass('alert-success').addClass('alert-danger').text('An error occurred: ' + error).show();

//              // Optionally, hide the error message after 3 seconds
//              setTimeout(function () {
//                  $('#message').hide();
//              }, 3000); // 3 seconds
//          }
//      });
//  });
// $('#queryForm').on('submit', function (e) {
//     e.preventDefault(); // Prevent the default form submission
//     const url = $(this).attr('action'); // Form action URL

//     // Disable the submit button and show the loader
//     $('#submitButton').prop('disabled', true); // Disable submit button
//     $('#loader').show(); // Show the loader next to the button

//     $.ajax({
//         url: url, // Form action URL
//         type: 'POST',
//         data: $(this).serialize(), // Serialize the form data

//         success: function (response) {
//             $('#loader').hide(); // Show the loader next to the button
//             if (response.success) {
//                 toastr.success(response.success, 'Success', {
//                     "positionClass": "toast-top-right", // Position the toast at the top right
//                     "timeOut": 3000 // Duration for which the toast is visible (in ms)
//                 });
//                 // Optionally reload or do something else after success
//                 setTimeout(function () {
//                     location.reload(); // Reload the page
//                 }, 3000);
//             }
//             // If the response contains an error message
//             else if (response.error) {
//                 toastr.error(response.error, 'Error', {
//                     "positionClass": "toast-top-right", // Position the toast at the top right
//                     "timeOut": 5000 // Duration for which the toast is visible (in ms)
//                 });
//                 // Reload the page after the toast
//                setTimeout(function() {
//                 location.reload();
//              }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
//             }
//         },
//         error: function (xhr, status, error) {
//             $('#loader').hide(); // Show the loader next to the button

//             toastr.error('An error occurred while processing the deletion.', 'Error', {
//                 "positionClass": "toast-top-right",  // Position it at the top right of the screen
//                 "timeOut": 5000  // Duration for which the toast is visible (in ms)
//             });
//             setTimeout(function () {
//                 location.reload(); // Reload the page
//             }, 3000);
//         }
//     });
// });
$(document).ready(function () {
    $('#queryForm').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission
        const url = $(this).attr('action'); // Form action URL
        $('#loader').show(); // Show loader before the request is sent
        $('#queryForm button[type="submit"]').prop('disabled', true);

        $.ajax({
            url: $(this).attr('action'), // Form action URL
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
        if (response.success) {
            toastr.success(response.message, 'Query form submitted', {
                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                "timeOut": 5000  // Duration for which the toast is visible (in ms)
            });
        } else {
            toastr.error(response.message, 'Error', {
                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                "timeOut": 5000  // Duration for which the toast is visible (in ms)
            });
        }
        $('#loader').hide(); // Hide loader after the request is complete

        setTimeout(function() {
            location.reload();
        }, 3000);
    },
    error: function (xhr, status, error) {
        // Handle any errors from the server here
        let errorMessage = 'An error occurred while submitting the form.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
            errorMessage = xhr.responseJSON.message;
        }

        // toastr.error(errorMessage, 'Error', {
        //     "positionClass": "toast-top-right",  // Position it at the top right of the screen
        //     "timeOut": 5000  // Duration for which the toast is visible (in ms)
        // });

        $('#loader').hide(); // Hide loader after error
    }
        
    });
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
                            0: "<b class='success'>Open</b>",
                            1: "<b class='warning'>In Progress</b>",
                            2: "<b class='info'>Reply</b>",
                            3: "<b class='deafult'>Closed</b>",
                            4: "<b class='danger'>Forward</b>"
                        };
                       console.log(employeeId);

                      
                        var row = '<tr>' +
                        '<td>' + (index + 1) + '.</td>' +
                        // '<td>' +
                        // // Condition to hide Name section
                        // ((employeeId == query.HodId || employeeId == query.RepMgrId) && query.HideYesNo == 'Y' ? '-' :
                        //     '<strong>Name:</strong> ' + query.Fname + ' ' + query.Lname + ' ' + query.Sname + '<br>' // Show Name if condition is not met
                        // ) +
                        // '</td>' +
                        '<td>' +
                              '<strong></strong> ' + query.Fname + ' ' + query.Sname + ' ' + query.Lname + '<br>' + // Combine Fname, Sname, Lname
                              '</td>' +
                        '<td>' +
                        '<strong>Subject:</strong> ' + query.QuerySubject + '<br>' +
                        '<strong>Subject Details:</strong> ' + query.QueryValue + '<br>' +
                        '<strong>Query to:</strong> ' + query.DepartmentName + '<br>' +
                        '</td>' +
                        '<td>' + (statusMap[query.QueryStatus_Emp] || 'N/A') + '</td>' +
                        '<td>' + (statusMap[query.Level_1QStatus] || 'N/A') + '</td>' +
                        '<td>' + (statusMap[query.Level_2QStatus] || 'N/A') + '</td>' +
                        '<td>' + (statusMap[query.Level_3QStatus] || 'N/A') + '</td>' +
                        '<td>' + (statusMap[query.Mngmt_QStatus] || 'N/A') + '</td>' +
                        '<td>' +
                        // Condition to hide Action button if employeeId is HodId or RepMgrId
                        ((employeeId == query.HodId || employeeId == query.RepMgrId) ? '-' :
                            (query.QueryStatus_Emp == 3 ?
                                '<button class="btn btn-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Action</button>' :
                                '<button class="btn btn-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action</button>'
                            )
                        ) +
                        '</td>' +
                        '</tr>';
                    
                    $('#employeeQueryTableBody').append(row);
                    
                       });
   
                       // Attach event listener to the "Take Action" buttons
                    //    $('.take-action-btn').on('click', function () {
                    //        var queryId = $(this).data('query-id');
   
                    //        var query = response.find(q => q.QueryId == queryId); // Find the query by ID
                    //        // Check if any status is 'Forwarded' (status code 4)
                    //        if (query.Level_1QStatus === 4 || query.Level_2QStatus === 4 || query.Level_3QStatus === 4 || query.Mngmt_QStatus === 4) {
                    //         console.log('Forwarded status found, resetting the status field');
                            
                    //         // Set status to 1 (or whatever value you want for forwarded status)
                    //         $('#status').val(''); // You can set this to whatever value makes sense in your case
                    //         console.log('Form field "status" has been updated to "1" due to forwarded status');
                    //     } else {
                    //         // If not forwarded, populate the status based on available data
                    //         if (query.Level_1QStatus) {
                    //             console.log('Setting status to Level 1: ' + query.Level_1QStatus);
                    //             $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                    //         } else if (query.Level_2QStatus) {
                    //             console.log('Setting status to Level 2: ' + query.Level_2QStatus);
                    //             $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                    //         } else if (query.Level_3QStatus) {
                    //             console.log('Setting status to Level 3: ' + query.Level_3QStatus);
                    //             $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                    //         } else if (query.Mngmt_QStatus) {
                    //             console.log('Setting status to Management: ' + query.Mngmt_QStatus);
                    //             $('#status').val(query.Mngmt_QStatus);  // Display Management Status
                    //         }
                    //     }
                    //        // Populate modal fields with query data
                    //        $('#querySubject').val(query.QuerySubject);
                    //        $('#querySubjectValue').val(query.QueryValue);
                    //        $('#queryName').val(query.Fname + ' ' + query.Sname + ' ' + query.Lname);
                    //        $('#queryDepartment').val(query.DepartmentName);
                    //     //    if (query.Level_1QStatus) {
                    //     //     console.log('ass');
                    //     //     $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                    //     //     } else if (query.Level_2QStatus) {
                    //     //         $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                    //     //     } else if (query.Level_3QStatus) {
                    //     //         $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                    //     //     }
                    
                    //     // Now, ensure the visibility of forward sections based on the selected status after setting it
                    //     toggleForwardSection($('#status').val());  // Reapply the visibility logic
                    //     if (query.Level_1QStatus === 3) {
                    //         $('#reply').val(query.Level_1ReplyAns).prop('readonly', true);  // Make read-only if Level 1 is closed
                    //     } else if (query.Level_2QStatus === 3) {
                    //         $('#reply').val(query.Level_2ReplyAns).prop('readonly', true);  // Make read-only if Level 2 is closed
                    //     } else if (query.Level_3QStatus === 3) {
                    //         $('#reply').val(query.Level_3ReplyAns).prop('readonly', true);  // Make read-only if Level 3 is closed
                    //     } else {
                    //         // If not closed, allow editing
                    //         $('#reply').prop('readonly', false);  // Make editable if the status is not closed
                    //     }  
                    //     console.log(query.QueryStatus_Emp);
                    //      // Disable the "Save Action" button if any of the Level statuses is 3 (Closed)
                    //         if (query.Level_1QStatus === 3 || query.Level_2QStatus === 3 || query.Level_3QStatus === 3|| query.QueryStatus_Emp === 3) {
                    //             $('button[type="submit"]').prop('disabled', true);  // Disable the Save Action button
                    //         } 
                    //         if (query.QueryStatus_Emp === 0) {
                    //             $('button[type="submit"]').prop('disabled', false);  // Disable the Save Action button
                    //         } 
                    //         else {
                    //             $('button[type="submit"]').prop('disabled', false);  // Enable the Save Action button if status is not closed
                    //         }                        
                    //         $('#forwardTo').empty(); // Clear the forwardTo dropdown
   
                    //        // Add the default option (value 0) for the "Forward To" dropdown
                    //        $('#forwardTo').append('<option value="0">Select a Forward To</option>');
   
                    //        // Fetch the DeptQSubject and AssignEmpId for the department and populate the "Forward To" dropdown
                    //        fetchDeptQuerySubForDepartment(queryId);
   
                    //        // Store query ID in the form
                    //        $('#queryActionForm').data('query-id', queryId);
   
                    //        // Show the modal
                    //        $('#actionModal').modal('show');
                    //    });
                    $('.take-action-btn').on('click', function () {
                        var queryId = $(this).data('query-id');
                        var query = response.find(q => q.QueryId == queryId); // Find the query by ID
                        
                        // Check if any status is 'Forwarded' (status code 4)
                        if (query.Level_1QStatus === 4 || query.Level_2QStatus === 4 || query.Level_3QStatus === 4 || query.Mngmt_QStatus === 4) {
                            console.log('Forwarded status found, resetting the status field');
                            
                            // Set status to 1 (or whatever value you want for forwarded status)
                            $('#status').val(''); // You can set this to whatever value makes sense in your case
                            console.log('Form field "status" has been updated to "1" due to forwarded status');
                        } else {
                            // If not forwarded, populate the status based on available data
                            if (query.Level_1QStatus) {
                                $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                            } else if (query.Level_2QStatus) {
                                $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                            } else if (query.Level_3QStatus) {
                                $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                            } else if (query.Mngmt_QStatus) {
                                $('#status').val(query.Mngmt_QStatus);  // Display Management Status
                            }
                        }
                    
                        // Add values in front of labels
                        $('#querySubject').before('<span>: ' + query.QuerySubject + '</span>');
                        $('#querySubjectValue').before('<span>: ' + query.QueryValue + '</span>');
                        $('#queryName').before('<span>: ' + query.Fname + ' ' + query.Sname + ' ' + query.Lname + '</span>');
                        $('#queryDepartment').before('<span>: ' + query.DepartmentName + '</span>');
                        
                        // Hide the input fields after adding values in front of labels
                        $('#querySubject').hide();
                        $('#querySubjectValue').hide();
                        $('#queryName').hide();
                        $('#queryDepartment').hide();
                    
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
                    
                        console.log(query.QueryStatus_Emp);
                    
                        // Disable the "Save Action" button if any of the Level statuses is 3 (Closed)
                        if (query.Level_1QStatus === 3 || query.Level_2QStatus === 3 || query.Level_3QStatus === 3 || query.QueryStatus_Emp === 3) {
                            $('button[type="submit"]').prop('disabled', true);  // Disable the Save Action button
                        }
                        if (query.QueryStatus_Emp === 0) {
                            $('button[type="submit"]').prop('disabled', false);  // Enable the Save Action button
                        } else {
                            $('button[type="submit"]').prop('disabled', false);  // Enable the Save Action button if status is not closed
                        }
                    
                        // Clear the forwardTo dropdown
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
       $('#status-loader').on('click', function () {
        $('#status').val(''); // Reset the status field
    
        // Set the "Select Option" as the default text for the dropdown
        $('#status option:first').prop('selected', true); // This will select the first option which is the "Select Status" text
    
        // Pass empty value to toggleForwardSection to reset visibility of related fields
        toggleForwardSection(''); // Call toggleForwardSection with empty value
    
    
        });
        function toggleForwardSection(status) {
            console.log('sadasdasd');
    
            // Default state when no option is selected (empty state)
            if (status === '') {
               
                $('#status option[value="4"]').show(); // Ensure "Forward" is visible
                $('#status option[value="1"]').show(); // Ensure "Closed" is visible
                $('#status option[value="2"]').show(); // Ensure "Closed" is visible
                $('#status option[value="3"]').hide(); // Ensure "Closed" is visible
    
            }
            
            // If "In Progress" (1) or "Reply" (2) is selected, hide "Forward" and show "Closed"
            else if (status == '1') {
                $('#replyremark').show(); // Hide "Forward To" field
                $('#status option[value="4"]').hide(); // Hide "Forward"
                $('#status option[value="3"]').show(); // Show "Closed"
                $('#status option[value="2"]').hide(); // Hide "reply"
                $('#forwardSection').hide(); // Hide "Forward To" field
                $('#forwardReasonSection').hide(); // Hide "Forward Reason" field
            }
            else if (status == '2') {
                $('#replyremark').show(); // Hide "Forward To" field
                $('#status option[value="4"]').hide(); // Hide "Forward"
                $('#status option[value="3"]').show(); // Show "Closed"
                $('#status option[value="1"]').hide(); // Hide "Forward"
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
                $('#replyremark').hide(); // Hide "Forward To" field
    
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
           $('#loader').show(); // Show the loader next to the button
   
           // Send the form data to the server via AJAX
           $.ajax({
               url: queryaction, // Route for your action handler
               method: 'POST',
               data: formData, // Send the serialized form data (includes CSRF token automatically)
               success: function (response) {
                $('#loader').hide(); // Show the loader next to the button
                console.log(response.message);
    
                toastr.success(response.message, 'Success', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 3000  // Duration for which the toast is visible (in ms)
                 });
                 // Reload the page after the toast
               setTimeout(function() {
                location.reload();
             }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
                 
            },
            error: function (xhr, status, error) {
                $('#loader').hide(); // Show the loader next to the button
    
                toastr.error('An error occurred while processing the deletion.', 'Error', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
                  // Reload the page after the toast
               setTimeout(function() {
                location.reload();
             }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
                
            }
           });
       });
   
   });
   //When the modal is hidden (i.e., closed), reset the form and any messages.
   
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
 $('#loader').show(); // Show the loader next to the button
 
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
     success: function (response) {
        $('#loader').hide(); // Show the loader next to the button
        console.log(response.message);

        toastr.success(response.message, 'Success', {
            "positionClass": "toast-top-right",  // Position it at the top right of the screen
            "timeOut": 3000  // Duration for which the toast is visible (in ms)
         });
           // Reload the page after the toast
           setTimeout(function() {
            location.reload();
         }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
        
    },
    error: function (xhr, status, error) {
        $('#loader').hide(); // Show the loader next to the button

        toastr.error('An error occurred while processing the deletion.', 'Error', {
            "positionClass": "toast-top-right",  // Position it at the top right of the screen
            "timeOut": 5000  // Duration for which the toast is visible (in ms)
        });
          // Reload the page after the toast
          setTimeout(function() {
            location.reload();
         }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
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
    var dataQueryStatus = $(this).data('query-status'); // Get the QueryStatus_Emp value
    var dataQueryRemark = $(this).data('query-remark'); // Get the remark value
    
    // Hide the existing modal if open
    $('#actionModal').modal('hide');
    
    // Show the action modal
    $('#actionModalEmp').modal('show');
    
    // Set the query ID in the modal for later use
    $('#actionQueryId').val(queryId);
    
    // Reset the 'selected' attribute for all options (clear previous selections)
    $('#actionStatus').find('option').prop('selected', false);

    // Show or hide the Action Status dropdown based on the value
    if (dataQueryStatus) {
        if (dataQueryStatus == '3') {
            // If status is 'Close', hide the dropdown and show text in front of the label
            $('#actionStatus').hide();
            $('#actionStatus').before('<span>: Close</span>');  // Show 'Close' text in front of label
            $('.sel_arrow').hide();

        } else {
            // Otherwise, show the dropdown and set the value
            $('#actionStatus').show();
            $('#actionStatus').before('<span>: ReOpen</span>');  // Show 'ReOpen' text in front of label
            $('.sel_arrow').hide();

        }
    }
    
    // Show or hide the Remark text based on the value
    if (dataQueryRemark) {
        // If a remark exists, display it as text and hide the textarea
        $('#actionRemark').hide();
        $('#actionRemark').before('<span>: ' + dataQueryRemark + '</span>'); // Display remark text before the label
    } else {
        // If no remark is provided, show default text and hide the textarea
        $('#actionRemark').show();
        //$('#actionRemark').before('<span>: No remark provided</span>'); // Show default remark text before the label
    }

    // Hide the rating section initially when modal is opened (if needed)
    $('#ratingSection').hide();
});




$(document).ready(function() {
    // Event listener for clicking the loader
$('#status-loader').on('click', function () {
    $('#status').val(''); // Reset the status field
    
    // Set the "Select Option" as the default text for the dropdown
    $('#status option:first').prop('selected', true); // This will select the first option which is the "Select Status" text

    // Pass empty value to toggleForwardSection to reset visibility of related fields
    toggleForwardSection(''); // Call toggleForwardSection with empty value

});
    // Initial state on page load: No option selected, dropdown options visible
    toggleForwardSection($("#status").val()); // Initialize visibility of forward section based on the selected status (or default blank)
    // Listen for changes to the "Status" dropdown
    $('#status').on('change', function () {
        var statusValue = $(this).val();
        toggleForwardSection(statusValue); // Adjust UI based on selected status
    });

    // Function to toggle visibility of forward section based on selected status
    function toggleForwardSection(status) {

        // Default state when no option is selected (empty state)
        if (status === '') {
           
            $('#status option[value="4"]').show(); // Ensure "Forward" is visible
            $('#status option[value="1"]').show(); // Ensure "Closed" is visible
            $('#status option[value="2"]').show(); // Ensure "Closed" is visible
            $('#status option[value="3"]').show(); // Ensure "Closed" is visible

        }
        
        // If "In Progress" (1) or "Reply" (2) is selected, hide "Forward" and show "Closed"
        else if (status == '1') {
            $('#replyremark').show(); // Hide "Forward To" field
            $('#status option[value="4"]').hide(); // Hide "Forward"
            $('#status option[value="3"]').show(); // Show "Closed"
            $('#status option[value="2"]').hide(); // Hide "reply"
            $('#forwardSection').hide(); // Hide "Forward To" field
            $('#forwardReasonSection').hide(); // Hide "Forward Reason" field
        }
        else if (status == '2') {
            $('#replyremark').show(); // Hide "Forward To" field
            $('#status option[value="4"]').hide(); // Hide "Forward"
            $('#status option[value="3"]').show(); // Show "Closed"
            $('#status option[value="1"]').hide(); // Hide "Forward"
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
            $('#replyremark').hide(); // Hide "Forward To" field

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
});
// Function to count words
function countWords(text) {
    return text.trim().split(/\s+/).length;
}

// Event listener for the textarea
document.getElementById('remarks').addEventListener('input', function () {
    var remarksText = this.value;
    var wordCount = countWords(remarksText);

    // Update the word count display
    document.getElementById('wordCount').textContent = wordCount + '/200 words';

    // Disable typing if word count exceeds 200
    if (wordCount > 200) {
        this.value = remarksText.split(/\s+/).slice(0, 200).join(' '); // Keep only first 200 words
        document.getElementById('wordCount').textContent = '200/200 words'; // Max reached
    }
});



