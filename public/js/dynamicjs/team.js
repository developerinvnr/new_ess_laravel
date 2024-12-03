document.addEventListener("DOMContentLoaded", function () {
    const requestCardsContainer = document.getElementById('requestcardsattendance');
    // requestCardsContainer.style.display = 'none';

    fetch(`/fetch-attendance-requests?employee_id=${employeeId}`)
        .then(response => response.json())
        .then(data => {
            const requestCardsContainer = document.getElementById('requestcardsattendance');
            const requestCards = document.getElementById('requestCards');

            // Clear existing content
            requestCards.innerHTML = '';


            if (data && data.message) {
                // If there's a message in 'data.message', show it in the alert
                const messageAlert = document.createElement('div');
                messageAlert.classList.add('alert', 'alert-warning', 'attendancedatanotfound');
                messageAlert.setAttribute('role', 'alert');
                messageAlert.textContent = data.message; // Display the message from the data
                requestCards.appendChild(messageAlert);
            }

            else {
                // Show the section if there are requests
                requestCardsContainer.style.display = 'flex';

                data.forEach(request => {
                    const requestCard = `
                    <div class="card p-3 mb-3 late-atnd">
                        <div class="img-thumb mb-1">
                            <div class="float-start emp-request-leave">
                                <img class="float-start me-2" src="images/users.png">
                                <b>Emp id: ${request.employeeDetails.EmployeeID}</b>
                                <p>${request.employeeDetails.Fname} ${request.employeeDetails.Sname} ${request.employeeDetails.Lname}</p>
                            </div>
                            <div class="float-end">
                                <a href="#" 
                                style="padding: 4px 10px; font-size: 10px;" 
                                class="mb-0 sm-btn mr-1 effect-btn btn btn-success approval-btn" 
                                title="Approval" 
                                data-bs-toggle="modal" 
                                data-bs-target="#AttendenceAuthorisationRequest"
                                data-request-date="${new Date(request.request.AttDate).toLocaleDateString('en-GB')}"
                                data-in-reason="${request.request.InReason || 'N/A'}"
                                data-in-remark="${request.request.InRemark || 'N/A'}"
                                data-out-reason="${request.request.OutReason || 'N/A'}"
                                data-out-remark="${request.request.OutRemark || 'N/A'}"
                                data-other-reason="${request.request.Reason || 'N/A'}"
                                data-other-remark="${request.request.Remark || 'N/A'}"
                                data-inn-time="${request.InTime || 'N/A'}"
                                data-out-time="${request.OutTime || 'N/A'}"
                                data-employee-id="${request.employeeDetails.EmployeeID || 'N/A'}">
                                    Approval
                                </a>
                                <a href="#" 
                                style="padding: 4px 10px; font-size: 10px;" 
                                class="mb-0 sm-btn effect-btn btn btn-danger reject-btn" 
                                title="Reject" 
                                data-bs-toggle="modal" 
                                data-bs-target="#AttendenceAuthorisationRequest"
                                data-request-date="${new Date(request.request.AttDate).toLocaleDateString('en-GB')}"
                                data-in-reason="${request.request.InReason || 'N/A'}"
                                data-in-remark="${request.request.InRemark || 'N/A'}"
                                data-out-reason="${request.request.OutReason || 'N/A'}"
                                data-out-remark="${request.request.OutRemark || 'N/A'}"
                                data-other-reason="${request.request.Reason || 'N/A'}"
                                data-other-remark="${request.request.Remark || 'N/A'}"
                                data-inn-time="${request.InTime || 'N/A'}"
                                data-out-time="${request.OutTime || 'N/A'}"
                                data-employee-id="${request.employeeDetails.EmployeeID || 'N/A'}">
                                    Reject
                                </a>
                            </div>
                        </div>
                        <div style="color:#777171; float: left; width: 100%; margin-top: 5px;">
                            <b class="float-start mr-2">${new Date(request.request.AttDate).toLocaleDateString('en-GB')}</b>
                            <span class="float-start">
                                Punch in 
                                <span class="${(request.InTime > request.II || request.InTime == '00:00:00') ? 'danger' : ''}">
                                    <b>${request.InTime || 'N/A'}</b>
                                </span>
                            </span>
                            <span class="float-end">
                                Punch Out 
                                <span class="${(request.OutTime < request.OO) ? 'danger' : ''}">
                                    <b>${request.OutTime || 'N/A'}</b>
                                </span>
                            </span>
                            <br>
                            <p>
                            <small>
                                ${request.request.Remark ? request.request.Remark : request.request.InRemark ? request.request.InRemark : 'No additional information.'}
                            </small>
                            </p>
                        </div>
                    </div>`;

                    document.getElementById('requestCards').insertAdjacentHTML('beforeend', requestCard);
                });

            }
        })
        .catch(error => {
            console.error('Error fetching requests:', error);
        });
});
const modal = document.getElementById('AttendenceAuthorisationRequest');
let inn_time; // Declare variables in the outer scope
let out_time;
modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const employeeId = button.getAttribute('data-employee-id'); // Get employee ID

    // Determine if the button is for approval or rejection
    const isApproval = button.classList.contains('approval-btn');
    const isReject = button.classList.contains('reject-btn');

    // Get dropdown elements
    const inStatusDropdown = document.getElementById('inStatusDropdown');
    const outStatusDropdown = document.getElementById('outStatusDropdown');
    const otherStatusDropdown = document.getElementById('otherStatusDropdown');

    // Preselect dropdown values based on the button clicked
    if (isApproval) {
        inStatusDropdown.value = 'approved';
        outStatusDropdown.value = 'approved';
        otherStatusDropdown.value = 'approved';
    } else if (isReject) {
        inStatusDropdown.value = 'rejected';
        outStatusDropdown.value = 'rejected';
        otherStatusDropdown.value = 'rejected';
    }

    // Set employee ID in a hidden input (to be submitted later)
    document.getElementById('employeeIdInput').value = employeeId;

    // Retrieve and display request-related information
    const requestDate = button.getAttribute('data-request-date');

    // Split the input date string to get day, month, and year
    const dateParts = requestDate.split('/');

    // Create a new Date object from the parts (Note: months are 0-based, so subtract 1 from the month)
    const dateObj = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

    // Define an array of month names
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    // Format the date
    const formattedDate = `${dateObj.getDate()}-${monthNames[dateObj.getMonth()]}-${dateObj.getFullYear()}`;

    // Set the formatted date in the textContent
    document.getElementById('request-date-repo').textContent = `Requested Date: ${formattedDate}`;


    // Reset all groups to be hidden initially
    const groups = [
        'statusGroupIn',
        'statusGroupOut',
        'statusGroupOther',
        'reasonInGroupReq',
        'reasonOutGroupReq',
        'reasonOtherGroupReq',
        'remarkInGroupReq',
        'remarkOutGroupReq',
        'remarkOtherGroupReq',
        'reportRemarkInGroup',
        'reportRemarkOutGroup',
        'reportRemarkOtherGroup'
    ];
    groups.forEach(group => {
        document.getElementById(group).style.display = 'none';
    });

    // Validate reasons
    const inReason = button.getAttribute('data-in-reason');
    const outReason = button.getAttribute('data-out-reason');
    const otherReason = button.getAttribute('data-other-reason');
    const isInReasonValid = inReason !== 'N/A';
    const isOutReasonValid = outReason !== 'N/A';
    const isOtherReasonValid = otherReason !== 'N/A';

    // Show sections based on reason validity
    if (isInReasonValid && isOutReasonValid) {
        // Show both "In" and "Out" sections
        document.getElementById('statusGroupIn').style.display = 'block';
        document.getElementById('reasonInGroupReq').style.display = 'block';
        document.getElementById('remarkInGroupReq').style.display = 'block';
        document.getElementById('reportRemarkInGroup').style.display = 'block';
        document.getElementById('reasonInDisplay').textContent = inReason;
        document.getElementById('remarkInReq').value = button.getAttribute('data-in-remark');

        document.getElementById('statusGroupOut').style.display = 'block';
        document.getElementById('reasonOutGroupReq').style.display = 'block';
        document.getElementById('remarkOutGroupReq').style.display = 'block';
        document.getElementById('reportRemarkOutGroup').style.display = 'block';
        document.getElementById('reasonOutDisplay').textContent = outReason;
        document.getElementById('remarkOutReq').value = button.getAttribute('data-out-remark');
    } else if (isInReasonValid) {
        // Show only "In" section
        document.getElementById('statusGroupIn').style.display = 'block';
        document.getElementById('reasonInGroupReq').style.display = 'block';
        document.getElementById('remarkInGroupReq').style.display = 'block';
        document.getElementById('reportRemarkInGroup').style.display = 'block';
        document.getElementById('reasonInDisplay').textContent = inReason;
        document.getElementById('remarkInReq').value = button.getAttribute('data-in-remark');
    } else if (isOutReasonValid) {
        // Show only "Out" section
        document.getElementById('statusGroupOut').style.display = 'block';
        document.getElementById('reasonOutGroupReq').style.display = 'block';
        document.getElementById('remarkOutGroupReq').style.display = 'block';
        document.getElementById('reportRemarkOutGroup').style.display = 'block';
        document.getElementById('reasonOutDisplay').textContent = outReason;
        document.getElementById('remarkOutReq').value = button.getAttribute('data-out-remark');
    } else if (!isInReasonValid && !isOutReasonValid && isOtherReasonValid) {
        // Show "Other" section only
        document.getElementById('statusGroupOther').style.display = 'block';
        document.getElementById('reasonOtherGroupReq').style.display = 'block';
        document.getElementById('remarkOtherGroupReq').style.display = 'block';
        document.getElementById('reportRemarkOtherGroup').style.display = 'block';
        document.getElementById('reasonOtherDisplay').textContent = otherReason;
        document.getElementById('remarkOtherReq').value = button.getAttribute('data-other-remark');
    }
});

document.getElementById('sendButtonReq').addEventListener('click', function () {
    const requestDateText = document.getElementById('request-date-repo').textContent;
    const requestDate = requestDateText.replace('Requested Date: ', '').trim();
    const employeeId = document.getElementById('employeeIdInput').value; // Get employee ID from hidden input

    // Prepare the data to be sent
    const formData = new FormData();
    formData.append('requestDate', requestDate);

    // Check visibility before appending values
    if (document.getElementById('statusGroupIn').style.display !== 'none') {
        const inStatus = document.getElementById('inStatusDropdown').value;
        const inReason = document.getElementById('reasonInDisplay').textContent;
        const inRemark = document.getElementById('remarkInReq').value;
        const reportRemarkIn = document.getElementById('reportRemarkInReq').value;

        if (inReason && inStatus) { // Append only if reason and status are valid
            formData.append('inStatus', inStatus);
            formData.append('inReason', inReason);
            formData.append('inRemark', inRemark);
            formData.append('reportRemarkIn', reportRemarkIn);
        }
    }

    if (document.getElementById('statusGroupOut').style.display !== 'none') {
        const outStatus = document.getElementById('outStatusDropdown').value;
        const outReason = document.getElementById('reasonOutDisplay').textContent;
        const outRemark = document.getElementById('remarkOutReq').value;
        const reportRemarkOut = document.getElementById('reportRemarkOutReq').value;

        if (outReason && outStatus) { // Append only if reason and status are valid
            formData.append('outStatus', outStatus);
            formData.append('outReason', outReason);
            formData.append('outRemark', outRemark);
            formData.append('reportRemarkOut', reportRemarkOut);
        }
    }

    if (document.getElementById('statusGroupOther').style.display !== 'none') {
        const otherStatus = document.getElementById('otherStatusDropdown').value;
        const otherReason = document.getElementById('reasonOtherDisplay').textContent;
        const otherRemark = document.getElementById('remarkOtherReq').value;
        const reportRemarkOther = document.getElementById('reportRemarkOtherReq').value;

        if (otherReason) { // Append only if reason is valid
            formData.append('otherStatus', otherStatus);
            formData.append('otherReason', otherReason);
            formData.append('otherRemark', otherRemark);
            formData.append('reportRemarkOther', reportRemarkOther);
        }
    }

    formData.append('employeeid', employeeId);
    formData.append('repo_employeeId', repo_employeeId);
    formData.append('inn_time', inn_time);
    formData.append('out_time', out_time);
    formData.append('_token', document.querySelector('input[name="_token"]').value); // CSRF token

    // Send the data using fetch
    fetch(`/attendance/updatestatus`, {
        method: 'POST',
        body: formData,
    })
        .then(response => {
            // Log the raw response for debugging
            return response.text().then(text => {
                // Check if the response is OK (status in the range 200-299)
                if (response.ok) {
                    // Check if the response text is not empty
                    if (text) {
                        return JSON.parse(text); // Parse JSON if text is not empty
                    } else {
                        throw new Error('Empty response from server');
                    }
                } else {
                    throw new Error(text); // Reject with the raw text if not OK
                }
            });
        })
        .then(data => {
            // Handle the JSON data returned from the server
            if (data.success) {
                alert('Data sent successfully!');
                $('#AttendenceAuthorisationRequest').modal('hide');
            } else {
                alert(data.message);
                // location.reload();
            }
        })
        .catch(error => {
            // Handle any errors that occurred during the fetch
            console.error('Error:', error);
            alert('There was a problem with your fetch operation: ' + error.message);
        });

});

function fetchLeaveRequests() {
    const leaveRequestsContainer = document.getElementById('leaveRequestsContainer');
    const mainBodyLeave = document.getElementById('leavemainrequest');
    // mainBodyLeave.style.display = 'none';

    fetch(`/leave-requests?employee_id=${employeeId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            leaveRequestsContainer.innerHTML = '';

            if (data.length > 0) {
                mainBodyLeave.style.display = 'flex';

                data.forEach(item => {
                    const leaveRequest = item.leaveRequest;
                    const employeeDetails = item.employeeDetails;

                    if (!leaveRequest || !employeeDetails) return; // Check if data exists

                    const card = document.createElement('div');
                    card.className = 'card p-3 mb-3';
                    card.style.border = '1px solid #ddd';

                    let actionButtons = '';
                    if (leaveRequest.LeaveStatus == '0' || leaveRequest.LeaveStatus == '3') {
                        // Pending state
                        actionButtons = `
                <button class="mb-0 sm-btn mr-1 effect-btn btn btn-success accept-btn" style="padding: 4px 10px; font-size: 10px;"
                    data-employee="${employeeDetails.EmployeeID}" 
                    data-name="${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}" 
                    data-from_date="${leaveRequest.Apply_FromDate}" 
                    data-to_date="${leaveRequest.Apply_ToDate}" 
                    data-reason="${leaveRequest.Apply_Reason}" 
                    data-total_days="${leaveRequest.Apply_TotalDay}" 
                    data-leavetype="${leaveRequest.Leave_Type}"
                    data-leavetype_day="${leaveRequest.half_define}">Accept</button>
                <button class="mb-0 sm-btn effect-btn btn btn-danger reject-btn"  style="padding: 4px 10px; font-size: 10px;"
                    data-employee="${employeeDetails.EmployeeID}" 
                    data-name="${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}" 
                    data-from_date="${leaveRequest.Apply_FromDate}" 
                    data-to_date="${leaveRequest.Apply_ToDate}" 
                    data-reason="${leaveRequest.Apply_Reason}" 
                    data-total_days="${leaveRequest.Apply_TotalDay}" 
                    data-leavetype="${leaveRequest.Leave_Type}"
                    data-leavetype_day="${leaveRequest.half_define}"
                    >Reject</button>
            `;
                    } else if (leaveRequest.LeaveStatus == '1') {
                        actionButtons = `<a href="#" class="mb-0 sm-btn effect-btn btn btn-success" title="Approved">Approved</a>`;
                    } else if (leaveRequest.LeaveStatus == '2') {
                        actionButtons = `<a href="#" class="mb-0 sm-btn effect-btn btn btn-danger" title="Rejected">Rejected</a>`;
                    }

                    card.innerHTML = `
            <div class="img-thumb mb-1" style="border-bottom: 1px solid #ddd;">
                <div class="float-start emp-request-leave">
                    <img class="float-start me-2" src="images/${employeeDetails.Image || 'users.png'}">
                    <b>Emp id: ${employeeDetails.EmployeeID}</b>
                    <p>${employeeDetails.Fname} ${employeeDetails.Sname} ${employeeDetails.Lname}</p>
                </div>
                <div class="float-end">
                    ${actionButtons}
                </div>
            </div>
            <div>
            
                <label class="mb-0 badge badge-secondary">${leaveRequest.Leave_Type}</label>
                <span class="me-3 ms-2"><b><small>${new Date(leaveRequest.Apply_FromDate).toLocaleDateString('en-GB')}</small></b></span>
                To <span class="ms-3 me-3"><b><small>${new Date(leaveRequest.Apply_Date).toLocaleDateString('en-GB')}</small></b></span>
                <span class="float-end btn-outline primary-outline p-0 pe-1 ps-1">
                    <small><b>${leaveRequest.Apply_TotalDay} Days</b></small>
                </span>
            </div>
            <p><small>${leaveRequest.Apply_Reason} <a data-bs-toggle="modal" data-bs-target="#approvalpopup" href="#" class="link btn-link p-0">..</a></small></p>
        `;

                    leaveRequestsContainer.appendChild(card);
                });

                // Attach event listeners only after rendering all cards
                attachEventListeners();
            } else {
                // No data found - Display message in the same format as "No Data Found"
                leaveRequestsContainer.innerHTML = `
                    <div class="alert alert-warning" role="alert">
                        No Leave Requests Found for this Employee.
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error fetching leave requests:', error);
            leaveRequestsContainer.innerHTML = '<p>Error fetching leave requests.</p>';
        });
}

// Fetch leave requests on page load
fetchLeaveRequests();
function attachEventListeners() {
    const acceptButtons = document.querySelectorAll('.accept-btn');
    const rejectButtons = document.querySelectorAll('.reject-btn');

    acceptButtons.forEach(button => {
        button.addEventListener('click', function () {
            populateModal(this, 'approved');
            $('#LeaveAuthorisation').modal('show');
        });
    });

    rejectButtons.forEach(button => {
        button.addEventListener('click', function () {
            populateModal(this, 'rejected');
            $('#LeaveAuthorisation').modal('show');
        });
    });
}

function populateModal(button, status) {
    document.getElementById('employeename').value = button.getAttribute('data-name');
    document.getElementById('leavetype').value = button.getAttribute('data-leavetype');
    document.getElementById('from_date').value = button.getAttribute('data-from_date');
    document.getElementById('to_date').value = button.getAttribute('data-to_date');
    document.getElementById('total_days').value = button.getAttribute('data-total_days');
    document.getElementById('leavereason').value = button.getAttribute('data-reason');
    document.getElementById('leavetype_day').value = button.getAttribute('data-leavetype_day');
    $('#leaveAuthorizationForm').data('employeeId', button.getAttribute('data-employee'));


    const statusDropdown = document.getElementById('StatusDropdown');
    statusDropdown.value = status; // Set 'approved' or 'rejected'
}

$(document).ready(function () {
      // Fetch employee queries when the page loads or refreshes
      fetchEmployeeQueries();
   
      function fetchEmployeeQueries() {
          $.ajax({
              url: getqueriesUrl, // Define the route for employee-specific queries
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
                                               var row = '<tr>' +
                              '<td>' + (index + 1) + '.</td>' +
                              '<td>' +
                              '<strong>Name:</strong> ' + query.Fname + ' ' + query.Lname + ' ' + query.Sname + '<br>' + // Combine Fname, Sname, Lname
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
                      $('.take-action-btn').on('click', function () {
                          var queryId = $(this).data('query-id');
  
                          var query = response.find(q => q.QueryId == queryId); // Find the query by ID
                          // Check if any status is 'Forwarded' (status code 4)
                          if (query.Level_1QStatus === 4 || query.Level_2QStatus === 4 || query.Level_3QStatus === 4 || query.Mngmt_QStatus === 4) {
                        //    console.log('Forwarded status found, resetting the status field');
                           
                           // Set status to 1 (or whatever value you want for forwarded status)
                           $('#status').val(''); // You can set this to whatever value makes sense in your case
                           //console.log('Form field "status" has been updated to "1" due to forwarded status');
                       } else {
                           // If not forwarded, populate the status based on available data
                           if (query.Level_1QStatus) {
                               //console.log('Setting status to Level 1: ' + query.Level_1QStatus);
                               $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                           } else if (query.Level_2QStatus) {
                            //    console.log('Setting status to Level 2: ' + query.Level_2QStatus);
                               $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                           } else if (query.Level_3QStatus) {
                            //    console.log('Setting status to Level 3: ' + query.Level_3QStatus);
                               $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                           } else if (query.Mngmt_QStatus) {
                            //    console.log('Setting status to Management: ' + query.Mngmt_QStatus);
                               $('#status').val(query.Mngmt_QStatus);  // Display Management Status
                           }
                       }
                          // Populate modal fields with query data
                          $('#querySubject').val(query.QuerySubject);
                          $('#querySubjectValue').val(query.QueryValue);
                          $('#queryName').val(query.Fname + ' ' + query.Sname + ' ' + query.Lname);
                          $('#queryDepartment').val(query.DepartmentName);
                       //    if (query.Level_1QStatus) {
                       //     console.log('ass');
                       //     $('#status').val(query.Level_1QStatus);  // Display Level 1 Status
                       //     } else if (query.Level_2QStatus) {
                       //         $('#status').val(query.Level_2QStatus);  // Display Level 2 Status
                       //     } else if (query.Level_3QStatus) {
                       //         $('#status').val(query.Level_3QStatus);  // Display Level 3 Status
                       //     }
                   
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
                    //    console.log(query.QueryStatus_Emp);
                        // Disable the "Save Action" button if any of the Level statuses is 3 (Closed)
                           if (query.Level_1QStatus === 3 || query.Level_2QStatus === 3 || query.Level_3QStatus === 3|| query.QueryStatus_Emp === 3) {
                               $('button[type="submit"]').prop('disabled', true);  // Disable the Save Action button
                           } 
                           if (query.QueryStatus_Emp === 0) {
                               $('button[type="submit"]').prop('disabled', false);  // Disable the Save Action button
                           } 
                           else {
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
      $('#status-loader').on('click', function () {
       $('#status').val(''); // Reset the status field
   
       // Set the "Select Option" as the default text for the dropdown
       $('#status option:first').prop('selected', true); // This will select the first option which is the "Select Status" text
   
       // Pass empty value to toggleForwardSection to reset visibility of related fields
       toggleForwardSection(''); // Call toggleForwardSection with empty value
   
   
       });
      function toggleForwardSection(status) {

       // Default state when no option is selected (empty state)
       if (status === '') {
           $('#status option[value="4"]').show(); // Ensure "Forward" is visible
           $('#status option[value="1"]').show(); // Ensure "Closed" is visible
           $('#status option[value="2"]').show(); // Ensure "Closed" is visible
           $('#status option[value="3"]').hide(); // Ensure "Closed" is visible

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
            url: deptQueryUrl, // Backend route to fetch DeptQSubject and AssignEmpId
            method: 'GET',
            data: { queryid: queryid },
            success: function (response) {
                // console.log(response); // To check the response structure

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
            url: queryactionUrl, // Route for your action handler
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
                        // location.reload();
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
    
    // Extract data from the button's data attributes
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
    
    // Get today's date in YYYY-MM-DD format
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;

    // Set the form fields in the modal
    $('#assestsid').val(assestsid);
    $('#employee_id').val(employeeId);
    $('#employee_name').val(employeeName); // Display Employee Name
    $('#asset_id').val(assetId);
    $('#req_amt').val(reqAmt);
    $('#reg_Date').val(reqDate);
    $('#approval_date').val(today);  // Set today's date
    $('#employeeId').val(employeeId);  // Set the Employee ID

   // Reset the form fields first, before checking and displaying any data
//    $('#approval_status').val('');  // Reset approval status dropdown to default
   $('#remark').val('');  // Clear the remark field

   // Handle Approval Status based on the role (HOD, IT, Accounts)
   if (button.data('hod-approval-status') !== undefined) {
       var hodApprovalStatus = button.data('hod-approval-status');
       console.log(hodApprovalStatus);
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
document.addEventListener('DOMContentLoaded', function() {
    // Dynamically passed employee data (e.g., from PHP)
    const employeeChainData = employeeChainDatatojs; // This will contain the PHP data as a JavaScript object

    // Step 1: Ensure RepEmployeeID is handled properly
    const employeeIds = new Set(employeeChainData.map(d => d.EmployeeID));  // Set of all valid EmployeeID

    const formattedData = employeeChainData.map(d => {
        // Check if RepEmployeeID exists in the dataset. If not, set it to null
        return {
            ...d,
            RepEmployeeID: employeeIds.has(d.RepEmployeeID) ? d.RepEmployeeID : null  // Only keep valid RepEmployeeID
        };
    });

    // Step 2: Extract distinct levels from the employee data
    const levels = [...new Set(employeeChainData.map(d => d.level))]; // Extract unique levels

    // Step 3: Populate the level dropdown dynamically
    const levelSelect = document.getElementById("levelSelect");
    levels.forEach(level => {
        const option = document.createElement("option");
        option.value = level;
        option.textContent = `Level ${level}`;
        levelSelect.appendChild(option);
    });

    // Default to show data for level 1 (or whatever the default is)
    levelSelect.value = "4"; // Change this as per your requirement
    renderTreeData(4);  // Initially render level 1 tree

    // Step 4: Add an event listener to handle the level change
    levelSelect.addEventListener("change", function() {
        const selectedLevel = parseInt(levelSelect.value);  // Get the selected level
        renderTreeData(selectedLevel);  // Re-render the tree based on the selected level
    });
    // Step 5: Function to render the tree based on the selected level
    function renderTreeData(level) {
        // Filter data for the selected level
        const filteredData = formattedData.filter(d => d.level <= level);  // Filter by the selected level

        // Clear existing tree content
        d3.select("#employeeTreeContainer").select("svg").remove();  // Remove previous tree (if any)

        // Set a fixed height for the tree (e.g., max height of 600px)
        const width = 1200;
        const maxHeight = 600;  // Set a max height for the tree
        const height = Math.min(filteredData.length * 120, maxHeight); // Dynamically adjust height, but limit it

        const treeLayout = d3.tree().size([width - 100, height - 100]);  // Adjusted size for vertical layout

        // Convert the employee data into a hierarchical structure using d3.stratify
        const root = d3.stratify()
            .id(d => d.EmployeeID)
            .parentId(d => d.RepEmployeeID)  // Use RepEmployeeID, which is now guaranteed to be valid or null
            (filteredData);

        // Generate the tree data
        const treeData = treeLayout(root);

        // Append the SVG element to the container
        const svg = d3.select("#employeeTreeContainer")
            .append("svg")
            .attr("width", width)
            .attr("height", height)
            .append("g")
            .attr("transform", `translate(50,90)`);  // Add margin for better positioning

        // Links (connecting lines between parent and child nodes)
        svg.selectAll(".link")
            .data(treeData.links())
            .enter()
            .append("line")
            .attr("class", "link")
            .attr("x1", d => d.source.x)  // Use 'x' for horizontal position
            .attr("y1", d => d.source.y)  // Use 'y' for vertical position
            .attr("x2", d => d.target.x)
            .attr("y2", d => d.target.y)
            .attr("stroke", "#a5cccd")
            .attr("stroke-width", 2);

        // Nodes (employee nodes)
        const nodes = svg.selectAll(".node")
            .data(treeData.descendants())
            .enter()
            .append("g")
            .attr("class", "node")
            .attr("transform", d => `translate(${d.x},${d.y})`);  // Use 'x' and 'y' for node position

        // Append rectangle boxes for each node (Width = 150, Height = 100)
        nodes.append("rect")
            .attr("x", -75) // Center the box horizontally (150/2 = 75)
            .attr("y", -50)  // Center the box vertically (100/2 = 50) -> Make sure it's not cut off
            .attr("width", 150) // Width of the box
            .attr("height", 100) // Height of the box
            .attr("rx", 10) // Rounded corners
            .attr("ry", 10) // Rounded corners
            .style("fill", "#a5cccd") // Background color
            .style("stroke", "#2980b9") // Border color
            .style("stroke-width", 2);

        // Append a circle behind the image for the employee avatar (background circle)
        nodes.append("a")
            .attr("href", "javascript:void(0);")
            .attr("class", "user-info")
            .append("circle") // Create a circle to be the background of the image
            .attr("cx", 0) // Position the center horizontally at 0 (middle of the box)
            .attr("cy", -40) // Position the center vertically above the name
            .attr("r", 20) // Radius of the circle (since the image is 40x40, we set it to half)
            .style("fill", "#75a9ab") // Set the background color to #75a9ab
            .style("stroke", "#2980b9") // Optional: Add a border color if needed
            .style("stroke-width", 2); // Optional: Border width for the circle

        // Append the first letter inside the circle (initials)
        nodes.append("text") // Add text element to display the first letter
            .attr("x", 0) // Position horizontally at the center
            .attr("y", -40) // Position vertically at the center of the circle
            .attr("text-anchor", "middle") // Align the text in the middle
            .attr("dominant-baseline", "middle") // Vertically align the text in the center
            .style("font-size", "18px") // Set the font size to fit inside the circle
            .style("font-weight", "bold") // Make the first letter bold
            .style("fill", "#fff") // Set the text color to white
            .text(d => d.data.Fname.charAt(0)); // Use the first letter of the first name

        // Function to generate dynamic abbreviation based on first letter of each word
        const getDynamicAbbreviation = (designation) => {
            // Split the designation by space and get the first letter of each word
            return designation.split(' ')
                              .map(word => word.charAt(0).toUpperCase()) // Get first letter of each word and convert to uppercase
                              .join(''); // Join the letters to form the abbreviation
        };

        // Append text labels for each node (Name)
        nodes.append("text")
            .attr("dy", 15) // Position the name text below the image (centered)
            .attr("text-anchor", "middle")
            .style("font-size", "12px")
            .style("font-weight", "bold")
            .style("fill", "#0a0a0a") // Text color (white for contrast)
            .text(d => `${d.data.Fname} ${d.data.Lname}`);

        // Append dynamic abbreviated designation text (Position it in the middle of the box)
        nodes.append("text")
            .attr("dy", 30) // Position below the name text
            .attr("text-anchor", "middle")
            .style("font-size", "10px")
            .style("fill", "#0a0a0a") // Text color (white for contrast)
            .text(d => d.data.DesigName ? getDynamicAbbreviation(d.data.DesigName) : ""); // Only append abbreviation if DesigName exists, otherwise append empty string
        
        // Step 6: Enable scrolling after the tree is rendered
        const treeContainer = document.getElementById("employeeTreeContainer");

        // Check if the content exceeds the container's height
        if (treeContainer.scrollHeight > treeContainer.clientHeight) {
            // Enable smooth scrolling behavior dynamically
            treeContainer.style.overflowY = 'auto';  // Allow vertical scrolling
            treeContainer.style.scrollBehavior = 'smooth';  // Apply smooth scrolling
        }
    }

    // Step 5: Function to render the tree based on the selected level
    // function renderTreeData(level) {
    //     // Filter data for the selected level
    //     const filteredData = formattedData.filter(d => d.level <= level);  // Filter by the selected level

    //     // Clear existing tree content
    //     d3.select("#employeeTreeContainer").select("svg").remove();  // Remove previous tree (if any)

    //     // Set up the dimensions of the tree
    //     const width = 1200;
    //     const height = filteredData.length * 120; // Adjust the height based on the number of nodes to prevent clipping

    //     const treeLayout = d3.tree().size([width - 100, height - 100]);  // Adjusted size for vertical layout

    //     // Convert the employee data into a hierarchical structure using d3.stratify
    //     const root = d3.stratify()
    //         .id(d => d.EmployeeID)
    //         .parentId(d => d.RepEmployeeID)  // Use RepEmployeeID, which is now guaranteed to be valid or null
    //         (filteredData);

    //     // Generate the tree data
    //     const treeData = treeLayout(root);

    //     // Append the SVG element to the container
    //     const svg = d3.select("#employeeTreeContainer")
    //         .append("svg")
    //         .attr("width", width)
    //         .attr("height", height)
    //         .append("g")
    //         .attr("transform", `translate(50,90)`);  // Add margin for better positioning

    //     // Links (connecting lines between parent and child nodes)
    //     svg.selectAll(".link")
    //         .data(treeData.links())
    //         .enter()
    //         .append("line")
    //         .attr("class", "link")
    //         .attr("x1", d => d.source.x)  // Use 'x' for horizontal position
    //         .attr("y1", d => d.source.y)  // Use 'y' for vertical position
    //         .attr("x2", d => d.target.x)
    //         .attr("y2", d => d.target.y)
    //         .attr("stroke", "#a5cccd")
    //         .attr("stroke-width", 2);

    //     // Nodes (employee nodes)
    //     const nodes = svg.selectAll(".node")
    //         .data(treeData.descendants())
    //         .enter()
    //         .append("g")
    //         .attr("class", "node")
    //         .attr("transform", d => `translate(${d.x},${d.y})`);  // Use 'x' and 'y' for node position

    //     // Append rectangle boxes for each node (Width = 150, Height = 100)
    //     nodes.append("rect")
    //         .attr("x", -75) // Center the box horizontally (150/2 = 75)
    //         .attr("y", -50)  // Center the box vertically (100/2 = 50) -> Make sure it's not cut off
    //         .attr("width", 150) // Width of the box
    //         .attr("height", 100) // Height of the box
    //         .attr("rx", 10) // Rounded corners
    //         .attr("ry", 10) // Rounded corners
    //         .style("fill", "#a5cccd") // Background color
    //         .style("stroke", "#2980b9") // Border color
    //         .style("stroke-width", 2);

    //     // Append a circle behind the image for the employee avatar (background circle)
    //     nodes.append("a")
    //         .attr("href", "javascript:void(0);")
    //         .attr("class", "user-info")
    //         .append("circle") // Create a circle to be the background of the image
    //         .attr("cx", 0) // Position the center horizontally at 0 (middle of the box)
    //         .attr("cy", -40) // Position the center vertically above the name
    //         .attr("r", 20) // Radius of the circle (since the image is 40x40, we set it to half)
    //         .style("fill", "#75a9ab") // Set the background color to #75a9ab
    //         .style("stroke", "#2980b9") // Optional: Add a border color if needed
    //         .style("stroke-width", 2); // Optional: Border width for the circle

    //     // Append the first letter inside the circle (initials)
    //     nodes.append("text") // Add text element to display the first letter
    //         .attr("x", 0) // Position horizontally at the center
    //         .attr("y", -40) // Position vertically at the center of the circle
    //         .attr("text-anchor", "middle") // Align the text in the middle
    //         .attr("dominant-baseline", "middle") // Vertically align the text in the center
    //         .style("font-size", "18px") // Set the font size to fit inside the circle
    //         .style("font-weight", "bold") // Make the first letter bold
    //         .style("fill", "#fff") // Set the text color to white
    //         .text(d => d.data.Fname.charAt(0)); // Use the first letter of the first name

    //     // Function to generate dynamic abbreviation based on first letter of each word
    //     const getDynamicAbbreviation = (designation) => {
    //         // Split the designation by space and get the first letter of each word
    //         return designation.split(' ')
    //                           .map(word => word.charAt(0).toUpperCase()) // Get first letter of each word and convert to uppercase
    //                           .join(''); // Join the letters to form the abbreviation
    //     };

    //     // Append text labels for each node (Name)
    //     nodes.append("text")
    //         .attr("dy", 15) // Position the name text below the image (centered)
    //         .attr("text-anchor", "middle")
    //         .style("font-size", "12px")
    //         .style("font-weight", "bold")
    //         .style("fill", "#0a0a0a") // Text color (white for contrast)
    //         .text(d => `${d.data.Fname} ${d.data.Lname}`);

    //     // Append dynamic abbreviated designation text (Position it in the middle of the box)
    //     nodes.append("text")
    //         .attr("dy", 30) // Position below the name text
    //         .attr("text-anchor", "middle")
    //         .style("font-size", "10px")
    //         .style("fill", "#0a0a0a") // Text color (white for contrast)
    //         .text(d => d.data.DesigName ? getDynamicAbbreviation(d.data.DesigName) : ""); // Only append abbreviation if DesigName exists, otherwise append empty string
    // }
});



