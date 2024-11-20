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
                    <div class="late-atnd">
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
                console.log('Raw response:', text); // Log the raw response
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
                location.reload();
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
                <span class="me-3 ms-2"><b><small>${leaveRequest.Apply_FromDate}</small></b></span>
                To <span class="ms-3 me-3"><b><small>${leaveRequest.Apply_ToDate}</small></b></span>
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
                            '<td>' + query.Level_1QStatus + '</td>' +
                            '<td>' + query.Level_2QStatus + '</td>' +
                            '<td>' + query.Level_3QStatus + '</td>' +
                            '<td>' + query.Mngmt_QStatus + '</td>' +
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
                        $('#status').val(query.Status);
                        $('#reply').val('');
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
                    console.log('ele');
                    // If no queries are found, display "No Data Found" message
                    $('#employeeQueryTab').hide(); // Hide the Employee Query tab
                    $('#employeeQuerySection').hide(); // Hide the Employee Specific Query section
                    $('#noEmployeeQueriesMessage').show(); // Show the "No Data Found" message

                    // Add a styled "No Data Found" message to the section
                    $('#noEmployeeQueriesMessage').html(`
                        <div class="alert alert-warning" role="alert">
                            No queries found for this employee.
                        </div>
                    `);
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
            url: deptQueryUrl, // Backend route to fetch DeptQSubject and AssignEmpId
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
document.addEventListener('DOMContentLoaded', function() {
    // Dynamically passed employee data (e.g., from PHP)
    const employeeChainData = employeeChainDatatojs; // This will contain the PHP data as a JavaScript object
    console.log(employeeChainData);

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
    levelSelect.value = "3"; // Change this as per your requirement
    renderTreeData(3);  // Initially render level 1 tree

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

        // Set up the dimensions of the tree
        const width = 1200;
        const height = 600; // Increased height to give space for the boxes

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
            .attr("transform", `translate(50,50)`);  // Add margin for better positioning

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
    }
});















