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
                // Reload the page after the toast
                setTimeout(function() {
                    location.reload();
                }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
        } else {
            toastr.error(response.message, 'Error', {
                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                "timeOut": 5000  // Duration for which the toast is visible (in ms)
            });
        }
        $('#loader').hide(); // Hide loader after the request is complete
        $('#queryForm button[type="submit"]').prop('disabled', false);


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
        $('#queryForm button[type="submit"]').prop('disabled', false);

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
                       var table = $('#employeeQueryListTable').DataTable();
                       table.clear(); // Clear existing table data
                       // Loop through each query and append to the table
                       $.each(response, function (index, query) {
                        var statusMap = {
                            0: "<b class='success'>Open</b>",
                            1: "<b class='warning'>In Progress</b>",
                            2: "<b class='info'>Reply</b>",
                            3: "<b class='default'>Closed</b>",
                            4: "<b class='danger'>Forward</b>"
                        };
       
                        
                        
                        // Create a new Date object using the string
                        var date = new Date(query.QueryDT);
                    
                        // Extract day, month, and year
                        var day = ('0' + date.getDate()).slice(-2); // Pad day with leading zero if needed
                        var month = ('0' + (date.getMonth() + 1)).slice(-2); // Pad month with leading zero if needed
                        var year = date.getFullYear();
                    
                        // Format as dd-mm-yyyy
                        var formattedDate = day + '-' + month + '-' + year;
                    
                        var row = '<tr>' +
                            '<td>' + (index + 1) + '.</td>' +
                            '<td>' + query.EmpCode+ '.</td>' +
                            '<td>' +
                                '<strong></strong> ' + query.Fname + ' ' + query.Sname + ' ' + query.Lname + '<br>' + // Combine Fname, Sname, Lname
                            '</td>' +
                            '<td>' + (formattedDate || 'N/A') + '</td>' +
                            '<td>' +
                                '<strong>Subject:</strong> ' + query.QuerySubject + '<br>' +
                                '<strong>Subject Details:</strong> ' + query.QueryValue + '<br>' +
                                '<strong>Query to:</strong> ' + query.department_name + '<br>' +
                            '</td>' +
                            '<td>' + (statusMap[query.QueryStatus_Emp] || 'N/A') + '</td>' +
                            '<td>' + (statusMap[query.Level_1QStatus] || 'N/A') + '</td>' +   // Concatenate the missing part here
                            '<td>' + (statusMap[query.Level_2QStatus] || 'N/A') + '</td>' +
                            '<td>' + (statusMap[query.Level_3QStatus] || 'N/A') + '</td>' +
                            '<td>' + (statusMap[query.Mngmt_QStatus] || 'N/A') + '</td>' +
                           '<td>' +
                                (function () {
                                    const currentDate = new Date().toISOString().split('T')[0]; // Current date in YYYY-MM-DD
                                    const level1Date = query.Level_1QToDT ? query.Level_1QToDT.split(' ')[0] : null; // Extract date only
                                    const level2Date = query.Level_2QToDT ? query.Level_2QToDT.split(' ')[0] : null; // Extract date only
                                    const level3Date = query.Level_3QToDT ? query.Level_3QToDT.split(' ')[0] : null; // Extract date only
                                    const levelMangDate = query.Mngmt_QToDT ? query.Mngmt_QToDT.split(' ')[0] : null; // Extract date only
                                    console.log(query);

                                    // Utility function to get the previous date
                                    const getPreviousDate = (dateString) => {
                                        if (!dateString) return null;
                                        const date = new Date(dateString);
                                        date.setDate(date.getDate() - 1); // Subtract 1 day
                                        return date.toISOString().split('T')[0];
                                    };

                                    // Check conditions for enabling/disabling the button
                                    if (
                                        (currentDate >= level1Date || currentDate === getPreviousDate(level2Date)) &&
                                        (employeeId == query.Level_1ID || 
                                        employeeId == query.Level_1QFwdEmpId || 
                                        employeeId == query.Level_1QFwdEmpId2 || 
                                        employeeId == query.Level_1QFwdEmpId3)
                                    ) {
                                        if (query.Level_1QStatus === 3) {

                                            // If status is 3, show "Closed" button
                                            return '<button class="btn badge-secondary btn-xs" disabled>Closed</button>';
                                        } 
                                        else if (currentDate > level2Date) {
                                            // If Level 1 date is exceeded, show "Action (Level 1)" button but disabled
                                            return '<button class="btn badge-secondary btn-xs" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Escalate</button>';
                                        }
                                        else{
                                        // Level 1 condition: Current date matches Level 1 date and employeeId matches Level 1 IDs
                                        return '<button class="btn badge-success btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action (Level 1)</button>';
                                        }
                                    } 
                                    else if (
                                        (currentDate >= level2Date || currentDate === getPreviousDate(level3Date)) &&
                                        (employeeId == query.Level_2ID || 
                                        employeeId == query.Level_2QFwdEmpId || 
                                        employeeId == query.Level_2QFwdEmpId2 || 
                                        employeeId == query.Level_2QFwdEmpId3)
                                    ) {
                                        if (query.Level_2QStatus === 3 || query.Level_1QStatus === 3) {

                                            // If status is 3, show "Closed" button
                                            return '<button class="btn badge-secondary btn-xs" disabled>Closed</button>';
                                        } 
                                        else if (currentDate > level3Date) {
                                            // If Level 1 date is exceeded, show "Action (Level 1)" button but disabled
                                            return '<button class="btn badge-secondary btn-xs" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Escalate</button>';
                                        }
                                        else{
                                        // Level 2 condition: Current date matches Level 2 date or one day before Level 3 date, and employeeId matches Level 2 IDs
                                        return '<button class="btn badge-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action (Level 2)</button>';
                                        }
                                    } else if (
                                        (currentDate >= level3Date || currentDate === getPreviousDate(levelMangDate)) &&
                                        (employeeId == query.Level_3ID || 
                                        employeeId == query.Level_3QFwdEmpId || 
                                        employeeId == query.Level_3QFwdEmpId2 || 
                                        employeeId == query.Level_3QFwdEmpId3)
                                    ) {
                                        if (query.Level_3QStatus === 3 || query.Level_2QStatus === 3 || query.Level_1QStatus === 3) {

                                            // If status is 3, show "Closed" button
                                            return '<button class="btn badge-secondary btn-xs" disabled>Closed</button>';
                                        } 
                                        else if (currentDate > levelMangDate) {
                                            // If Level 1 date is exceeded, show "Action (Level 1)" button but disabled
                                            return '<button class="btn badge-secondary btn-xs" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Escalate</button>';
                                        }
                                        else{
                                        // Level 3 condition: Current date matches Level 3 date and employeeId matches Level 3 IDs
                                            return '<button class="btn badge-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action (Level 3)</button>';
                                        }
                                    } 
                                    if (
                                        currentDate === levelMangDate &&
                                        (employeeId == query.Mngmt_ID || 
                                         employeeId == query.Mngmt_QFwdEmpId || 
                                         employeeId == query.Mngmt_QFwdEmpId2 || 
                                         employeeId == query.Mngmt_QFwdEmpId3)
                                    ) {
                                        // Check the status to determine which button to display
                                        if (query.Mngmt_QStatus === 3 || query.Level_3QStatus === 3 || query.Level_2QStatus === 3 || query.Level_1QStatus === 3) {
                                            console.log('query.Mngmt_QStatus');

                                            // If status is 3, show "Closed" button
                                            return '<button class="btn badge-secondary btn-xs" disabled>Closed</button>';
                                        } else {
                                            console.log(query.Mngmt_QStatus);
                                            // Otherwise, show "Action (Mang.)" button
                                            return '<button class="btn badge-primary btn-xs" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action (Mang.)</button>';
                                        }
                                    }
                                    
                                    else {
                                        // Default: Button disabled if none of the conditions match
                                        return '<button class="btn badge-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Action</button>';
                                    }
                                })() +

                            '</td>'+
                            '<td>' +
                                '<button type="button" class="btn badge-primary btn-xs" onclick="showQueryDetails(\'' + query.QueryId + '\')">View</button>' +
                            '</td>';




                            // '<td>' +
                            // // Condition to hide Action button if employeeId is HodId or RepMgrId
                            // // ((employeeId == query.HodId || employeeId == query.RepMgrId) ? '-' :
                            //     // (query.QueryStatus_Emp == 3 ?
                            //         '<button class="btn btn-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '" disabled>Action</button>' :
                            //         '<button class="btn btn-primary btn-xs take-action-btn" data-query-id="' + query.QueryId + '" data-department-id="' + query.QToDepartmentId + '">Action</button>'
                            //     // )
                            // // ) 
                            
                            // '</td>' +
                            '</tr>';
                            table.row.add($(row)); // Add the row using DataTables API

                        // $('#employeeQueryTableBody').append(row);
                    });
                    
                    table.draw(); // Redraw the table with new data
                    $('#statusFilter').on('change', function () {
                        var selectedValue = $(this).val(); // Get the selected filter value
                        var statusMapFilter = {
                            '0': 'Open',
                            '1': 'In Progress',
                            '2': 'Reply',
                            '3': 'Closed',
                            '4': 'Forward'
                        };
                    
                        // If no value is selected ("All"), reset the search on all rows
                        if (selectedValue === "") {
                            table.search('').draw(); // Reset the global search
                        } else {
                            var selectedStatus = statusMapFilter[selectedValue];
                    
                            // Add a custom search function for filtering rows globally
                            $.fn.dataTable.ext.search.push(function (settings, rowData, rowIndex) {
                                // Get column data for the current row
                                var level1Status = rowData[6]; // Level 1 column
                                var level2Status = rowData[7]; // Level 2 column
                                var level3Status = rowData[8]; // Level 3 column
                                var managementStatus = rowData[9]; // Management column
                    
                                // Check if the employeeId matches and the status in the column matches the selected filter
                                var matchesLevel1 =
                                    (employeeId == response[rowIndex].Level_1ID ||
                                        employeeId == response[rowIndex].Level_1QFwdEmpId ||
                                        employeeId == response[rowIndex].Level_1QFwdEmpId2 ||
                                        employeeId == response[rowIndex].Level_1QFwdEmpId3) &&
                                    level1Status.includes(selectedStatus);
                    
                                var matchesLevel2 =
                                    (employeeId == response[rowIndex].Level_2ID ||
                                        employeeId == response[rowIndex].Level_2QFwdEmpId ||
                                        employeeId == response[rowIndex].Level_2QFwdEmpId2 ||
                                        employeeId == response[rowIndex].Level_2QFwdEmpId3) &&
                                    level2Status.includes(selectedStatus);
                    
                                var matchesLevel3 =
                                    (employeeId == response[rowIndex].Level_3ID ||
                                        employeeId == response[rowIndex].Level_3QFwdEmpId ||
                                        employeeId == response[rowIndex].Level_3QFwdEmpId2 ||
                                        employeeId == response[rowIndex].Level_3QFwdEmpId3) &&
                                    level3Status.includes(selectedStatus);
                    
                                var matchesManagement =
                                    (employeeId == response[rowIndex].Mngmt_ID ||
                                        employeeId == response[rowIndex].Mngmt_QFwdEmpId ||
                                        employeeId == response[rowIndex].Mngmt_QFwdEmpId2 ||
                                        employeeId == response[rowIndex].Mngmt_QFwdEmpId3) &&
                                    managementStatus.includes(selectedStatus);
                    
                                // Return true if any level matches
                                return matchesLevel1 || matchesLevel2 || matchesLevel3 || matchesManagement;
                            });
                    
                            // Redraw the table with the new global filter
                            table.draw();
                    
                            // Remove the custom filter after applying it (optional, to avoid conflicts with future filters)
                            $.fn.dataTable.ext.search.pop();
                        }
                    });
                    
                    

                
                    $('#employeeQueryListTable').on('click', '.take-action-btn', function () {
                        console.log('take action clicked');
                        var queryId = $(this).data('query-id');
                        var query = response.find(q => q.QueryId == queryId); // Find the query by ID
                        clearModalFields(); // Function to reset all fields in the modal

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
                        // Show the "Closed" option conditionally based on query status
                        if (query.Level_1QStatus === 2 || query.Level_2QStatus === 2 ||  query.Level_3QStatus === 2 ||  query.Mngmt_QStatus === 2) {
                            $('#closedStatusOption').show();  // Show Closed option if the query is closed
                        } else {
                            $('#closedStatusOption').hide();  // Hide the "Closed" option if not closed
                        }
                        // Add values in front of labels
                        $('#querySubject').before('<span>: ' + query.QuerySubject + '</span>');
                        $('#querySubjectValue').before('<span>: ' + query.QueryValue + '</span>');
                        $('#queryName').before('<span>: ' + query.Fname + ' ' + query.Sname + ' ' + query.Lname + '</span>');
                        $('#queryDepartment').before('<span>: ' + query.department_name + '</span>');
                        if (query.Level_1ReplyAns || query.Level_2ReplyAns || query.Level_3ReplyAns || query.Mngmt_ReplyAns) {
                            // $('#reply').hide();
                            // $('#reply_span').hide();
                        
                            // Check which reply exists and display it
                            let replyText = query.Level_1ReplyAns || query.Level_2ReplyAns || query.Level_3ReplyAns || query.Mngmt_ReplyAns;
                        
                            // $('#reply_span').before('<span>: ' + replyText + '</span>');
                        }
                        else{
                            $('#reply').show();

                        }
                        
                        // Hide the input fields after adding values in front of labels
                        $('#querySubject').hide();
                        $('#querySubjectValue').hide();
                        $('#queryName').hide();
                        $('#queryDepartment').hide();
                    
                       
                    
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
                    function clearModalFields() {
                        // Clear all input fields in the modal
                        $('#status').val(''); // Reset status field
                        $('#reply').val('').prop('readonly', false); // Reset reply field and make editable
                        $('#querySubject').show(); // Show the query subject field again
                        $('#querySubjectValue').show(); // Show the query subject value field
                        $('#queryName').show(); // Show the query name field
                        $('#queryDepartment').show(); // Show the query department field
                        $('#forwardTo').empty(); // Clear the "Forward To" dropdown
                        $('#forwardTo').append('<option value="0">Select a Forward To</option>'); // Reset dropdown to default
                        $('#reply_span').empty(); // Clear the reply span content
                    }
   
                   } 
                   
                   
                   
                   else {
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
                        console.log(item);
                        var fullName = item.fname + ' ' + item.sname + ' ' + item.lname;

                           var option = $('<option></option>')
                                        .attr('value', item.EmployeeID) // Set EmployeeID as the value
                                        .text(fullName); // Set full name as the text
                                
                            //    .attr('value', item.EmployeeID) // Set the value to AssignEmpId
                            //    .data('deptqsubject', item.DeptQSubject) // Store DeptQSubject as data
                            //    .text(item.DeptQSubject); // Display DeptQSubject in the dropdown
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
                $('#loader').hide(); // Hide the loader next to the button
                if (response.success) {
                    // If the response indicates success
                    toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right",  // Position it at the top right of the screen
                        "timeOut": 3000  // Duration for which the toast is visible (in ms)
                    });
    
                    // Reload the page after the toast
                    setTimeout(function() {
                        location.reload();
                    }, 3000);  // Delay the reload to match the timeOut value of the toast (5000ms)
                } else {
                    // If the response indicates failure
                    toastr.error(response.message, 'Error', {
                        "positionClass": "toast-top-right",  // Position it at the top right of the screen
                        "timeOut": 5000  // Duration for which the toast is visible (in ms)
                    });
                }
            },
            error: function (xhr, status, error) {
                $('#loader').hide(); // Hide the loader next to the button
    
                toastr.error('An error occurred while processing the request.', 'Error', {
                    "positionClass": "toast-top-right",  // Position it at the top right of the screen
                    "timeOut": 5000  // Duration for which the toast is visible (in ms)
                });
            }
           });
       });
   
   });
   //When the modal is hidden (i.e., closed), reset the form and any messages.
   
//    $(document).ready(function () {
//        $('#actionModal').on('hidden.bs.modal', function () {
//            location.reload(); // Reloads the page when the modal is closed
//        });
//    });
   
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
        $('#loader').hide(); // Hide the loader
    
        // Check if the response indicates success or failure
        if (response.success) {
            // If the request was successful
            console.log(response.message);
    
            toastr.success(response.message, 'Success', {
                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                "timeOut": 3000  // Duration for which the toast is visible (in ms)
            });
    
            // Reload the page after the toast
            setTimeout(function() {
                location.reload();
            }, 3000);  // Delay the reload to match the timeOut value of the toast (3000ms)
        } else {
            // If the response indicates failure
            toastr.error(response.message, 'Error', {
                "positionClass": "toast-top-right",  // Position it at the top right of the screen
                "timeOut": 5000  // Duration for which the toast is visible (in ms)
            });
        }
    },
    error: function (xhr, status, error) {
        $('#loader').hide(); // Hide the loader in case of an error
    
        toastr.error('An error occurred while processing the request.', 'Error', {
            "positionClass": "toast-top-right",  // Position it at the top right of the screen
            "timeOut": 5000  // Duration for which the toast is visible (in ms)
        });
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
            $('#submitAction').hide();
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
// Helper function to format date (if needed)
function formatDate(dateStr) {
    var date = new Date(dateStr);
    var day = ("0" + date.getDate()).slice(-2); // Ensure two-digit day
    var month = ("0" + (date.getMonth() + 1)).slice(-2); // Ensure two-digit month
    var year = date.getFullYear();
    return day + "/" + month + "/" + year;
}






