
document.addEventListener('DOMContentLoaded', function () {
    const currentDate = new Date();
    const currentMonthIndex = currentDate.getMonth(); // 0 = January, 1 = February, etc.
    const currentYear = currentDate.getFullYear();

    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    const monthDropdown = document.getElementById('monthname');
    const cardHeaders = document.querySelectorAll('.card-header h4');
    const late_card_header = document.querySelector('#late_card_header h4');


    monthDropdown.innerHTML = `<option value="select">Select Month</option>`;

    // Populate the dropdown with all months
    for (let i = currentMonthIndex; i >= 0; i--) {
        const month = monthNames[i];
        monthDropdown.innerHTML += `<option value="${month}">${month}</option>`;
    }
    // Optionally select the current month
    // monthDropdown.value = monthNames[currentMonthIndex];

    // Add the previous month option
    const previousMonthIndex = (currentMonthIndex - 1 + 12) % 12;
    const previousMonth = monthNames[previousMonthIndex];
    // monthDropdown.innerHTML += `<option value="${previousMonth}">${previousMonth}</option>`;

    // Fetch attendance data for the current month on page load
    fetchAttendanceData(monthNames[currentMonthIndex], currentYear);
    const rowsPerPage = 5; // Number of records per page
    const rows = document.querySelectorAll('.leave-row'); // Get all leave rows
    const pagination = document.getElementById('pagination');
    const totalPages = Math.ceil(rows.length / rowsPerPage);

    function showPage(page) {
        // Hide all rows
        rows.forEach((row, index) => {
            row.style.display = (Math.floor(index / rowsPerPage) === page) ? '' : 'none';
        });
    }

    function createPagination() {

        for (let i = 0; i < totalPages; i++) {
            const li = document.createElement('li');

            li.className = 'page-item';
            li.innerHTML = `<a class="page-link" href="#">${i + 1}</a>`;

            li.addEventListener('click', function () {
                showPage(i);
            });
            pagination.appendChild(li);
        }
    }

    createPagination();
    showPage(0);

    const leaveTypeSelect = document.getElementById('leaveType');
    const holidayDropdown = document.getElementById('holidayDropdown');
    const optionSelect = document.getElementById('option');
    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');
    const slDateSectionFrom = document.getElementById('slDateSectionFrom');
    const slDateSectionTo = document.getElementById('slDateSectionTo');
    const fromDateSLInput = document.getElementById('fromDateSL');
    const toDateSLInput = document.getElementById('toDateSL');

    // Leave balances
    const balanceCL = balanceCL; // Casual Leave balance
    const balanceSL = balanceSL; // Sick Leave balance
    console.log(balanceCL);
    leaveTypeSelect.addEventListener('change', function () {
        console.log(this.value);

        // Reset the option selection
        optionSelect.selectedIndex = 0; // Reset to the first option
        holidayDropdown.style.display = 'none'; // Hide holiday dropdown by default
        optionSelect.querySelectorAll('option').forEach(option => {
            option.style.display = 'block'; // Reset to show all options
        });

        // Show general date fields
        fromDateInput.parentElement.parentElement.style.display = 'block'; // Show general From Date
        toDateInput.parentElement.parentElement.style.display = 'block'; // Show general To Date



        if (this.value === 'OL') {
            festivalLeaveMessage.style.display = 'none';
            holidayDropdown.style.display = 'block';
            optionSelect.value = 'fullday'; // Auto-select Full Day
            optionSelect.querySelectorAll('option').forEach(option => {
                option.style.display = (option.value === 'fullday') ? 'block' : 'none'; // Hide others
            });
            let isNoHolidayAvailable = false;
                holidayDropdown.querySelectorAll('option').forEach(option => {
                    if (option.textContent === "No optional holidays available") {
                        isNoHolidayAvailable = true;
                    }
                });

                // If "No optional holidays available" is found, disable the date fields and show a message
                if (isNoHolidayAvailable) {
                    // Clear the date fields first
                    fromDateInput.value = ''; 
                    toDateInput.value = '';   

                    // Disable the date fields
                    fromDateInput.disabled = true;
                    toDateInput.disabled = true;

                    // Set the text color to red
                    fromDateInput.style.color = "red";
                    toDateInput.style.color = "red";
                    festivalLeaveMessage.style.display = 'block';

                }

        } else if (this.value === 'EL' || this.value === 'PL') {
            holidayDropdown.style.display = 'none';
            optionSelect.value = 'fullday'; // Auto-select Full Day
            optionSelect.querySelectorAll('option').forEach(option => {
                option.style.display = (option.value === 'fullday') ? 'block' : 'none'; // Hide others
            });
            setDateLimits();
        } else if (this.value === 'CL') {
            holidayDropdown.style.display = 'none';
            optionSelect.value = 'fullday'; // Auto-select Full Day

            // Determine which options to show based on leave balance
            if (balanceCL >= 1) {
                optionSelect.querySelectorAll('option').forEach(option => {
                    option.style.display = 'block'; // Show all options
                });
            } else {
                optionSelect.querySelectorAll('option').forEach(option => {
                    if (option.value === '1sthalf' || option.value === '2ndhalf') {
                        option.style.display = 'block'; // Show half-day options
                    } else {
                        option.style.display = 'none'; // Hide full day option
                    }
                });
            }
            setDateLimits();
        } else if (this.value === 'SL') {
            fromDateInput.parentElement.parentElement.style.display = 'block'; // Show general From Date
            toDateInput.parentElement.parentElement.style.display = 'block'; // Show general To Date

            // Determine options based on Sick Leave balance
            if (balanceSL >= 1) {
                optionSelect.querySelectorAll('option').forEach(option => {
                    option.style.display = 'block'; // Show all options
                });
            } else {
                optionSelect.querySelectorAll('option').forEach(option => {
                    if (option.value === '1sthalf' || option.value === '2ndhalf') {
                        option.style.display = 'block'; // Show half-day options
                    } else {
                        option.style.display = 'none'; // Hide full day option
                    }
                });
            }
            setDateLimits();
        }

        function setDateLimits() {
            // Reset date inputs min and max when changing leave type
            const currentDate = new Date();
            const threeDaysAgo = new Date(currentDate);
            threeDaysAgo.setDate(currentDate.getDate() - 3);
            const minDate = threeDaysAgo.toISOString().split('T')[0]; // Three days ago

            // Set min dates for the general inputs
            fromDateInput.min = minDate; // Allow dates from 3 days ago
            toDateInput.min = minDate; // Allow dates from 3 days ago

            // Clear max to allow selection of any past date
            fromDateInput.max = ""; // No maximum limit
            toDateInput.max = ""; // No maximum limit

            // Default to today's date
            fromDateInput.value = currentDate.toISOString().split('T')[0]; // Default From Date to today
            toDateInput.value = currentDate.toISOString().split('T')[0]; // Default To Date to today
        }
    });

    document.getElementById('optionalHoliday').addEventListener('change', function () {
        const selectedHolidayDate = new Date(this.value); // Get selected holiday date
        console.log(selectedHolidayDate);
        const year = selectedHolidayDate.getFullYear();
        const month = selectedHolidayDate.getMonth(); // Month is zero-indexed

        // Get the first and last day of the selected month
        const firstDayOfMonth = new Date(year, month, 1); // First day of the month
        const lastDayOfMonth = new Date(year, month + 1, 0); // Last day of the month

        // Function to format date as yyyy-mm-dd (required by the date input field)
        function formatDateForInput(date) {
            const day = String(date.getDate()).padStart(2, '0'); // Ensure two digits
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Ensure two digits, zero-indexed month
            const year = date.getFullYear();
            return `${year}-${month}-${day}`; // Return date in yyyy-mm-dd format
        }

        // Set the fromDateInput and toDateInput values in yyyy-mm-dd format
        fromDateInput.value = formatDateForInput(selectedHolidayDate);
        toDateInput.value = formatDateForInput(selectedHolidayDate);

        // Set min and max for both date inputs (in yyyy-mm-dd format)
        fromDateInput.min = formatDateForInput(firstDayOfMonth);
        fromDateInput.max = formatDateForInput(lastDayOfMonth);
        toDateInput.min = formatDateForInput(firstDayOfMonth);
        toDateInput.max = formatDateForInput(lastDayOfMonth);
    });
    



    monthDropdown.addEventListener('change', function () {
        const selectedMonth = this.value;
        if (selectedMonth !== "select") {
            fetchAttendanceData(selectedMonth, currentYear);
        }
    });
    // document.addEventListener('click', function (event) {
    //     if (event.target.closest('.open-modal')) {
    //         event.preventDefault();

    //         const link = event.target.closest('.open-modal');
    //         const employeeId = link.getAttribute('data-employee-id');
    //         const date = link.getAttribute('data-date');
    //         const innTime = link.getAttribute('data-inn');
    //         const outTime = link.getAttribute('data-out');
    //         const II = link.getAttribute('data-II');
    //         const OO = link.getAttribute('data-OO');
    //         const atct = link.getAttribute('data-atct');
    //         const dataexist = link.getAttribute('data-exist');
    //         const status = link.getAttribute('data-status');
    //         const draft = link.getAttribute('data-draft');
    //         // Determine classes based on conditions
    //         const lateClass = (innTime > II) ? 'text-danger' : '';
    //         const earlyClass = (outTime < OO) ? 'text-danger' : '';
    //         // Initialize content for request-date
    //         if (dataexist === 'true') {
    //             // Select the modal footer and hide it
    //             const modalFooter = document.getElementById('modal-footer');
    //             console.log(modalFooter)
    //             if (modalFooter) {
    //                 modalFooter.style.display = 'none';
    //             }
    //         }
    //         console.log(draft);
    //         // Initialize content for request-date
    //         let requestDateContent = `
    //                 <div style="text-align: left;">
    //                     <b>Request Date: ${date}</b>
    //                     <span style="color: ${draft === '3' || draft === null ? 'red' : (status === '1' ? 'green' : 'red')}; float: right; ${draft === '0' ? 'display: none;' : ''}">
    //                         <b style="color: black; font-weight: bold;">Status:</b> 
    //                         ${draft === '3' || draft === null ? 'Draft' : (status === '1' ? 'Approved' : 'Rejected')}
    //                     </span>
    //                 </div>
    //             `;
    //         // Check conditions for In
    //         if (innTime > II) {
    //             requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
    //         } else if (innTime <= II) {
    //             requestDateContent += `In: <span>${innTime}On Time</span><br>`; // Optional: show "On Time" if needed
    //         }

    //         // Check conditions for Out
    //         if (outTime < OO) {
    //             requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
    //         } else if (outTime >= OO) {
    //             requestDateContent += `Out: <span>${outTime}On Time</span>`; // Optional: show "On Time" if needed
    //         }

    //         // Set innerHTML only if there is content to display
    //         document.getElementById('request-date').innerHTML = requestDateContent;

    //         document.getElementById('employeeid').value = employeeId;
    //         document.getElementById('Atct').value = atct;
    //         document.getElementById('requestDate').value = date;

    //         // Clear previous values and hide all groups
    //         document.getElementById('remarkIn').value = '';
    //         document.getElementById('remarkOut').value = '';
    //         // document.getElementById('reasonInDropdown').innerHTML = '';
    //         // document.getElementById('reasonOutDropdown').innerHTML = '';

    //         document.getElementById('reasonInGroup').style.display = 'none';
    //         document.getElementById('remarkInGroup').style.display = 'none';
    //         document.getElementById('reasonOutGroup').style.display = 'none';
    //         document.getElementById('remarkOutGroup').style.display = 'none';

    //         // Fetch company_id and department_id based on employeeId
    //         fetch(`/api/getEmployeeDetails/${employeeId}`)
    //             .then(response => response.json())
    //             .then(data => {
    //                 console.log(data);
    //                 const companyId = data.company_id;
    //                 const departmentId = data.department_id;

    //                 // Fetch reasons based on companyId and departmentId
    //                 return fetch(`/api/getReasons/${companyId}/${departmentId}`);
    //             })
    //             .then(response => response.json())
    //             .then(reasons => {
    //                 // Function to clear existing options in the dropdowns
    //                 function clearDropdown(dropdownId) {
    //                     const dropdown = document.getElementById(dropdownId);
    //                     // Clear all existing options
    //                     dropdown.innerHTML = '';
    //                 }

    //                 // Clear existing options in all dropdowns
    //                 clearDropdown('reasonInDropdown');
    //                 clearDropdown('reasonOutDropdown');
    //                 clearDropdown('otherReasonDropdown');

    //                 // Add default "Select Option" as the first option for each dropdown
    //                 const defaultOption = document.createElement('option');
    //                 defaultOption.value = '';  // empty value for "Select Option"
    //                 defaultOption.textContent = 'Select Option';

    //                 document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonInDropdown'
    //                 document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonOutDropdown'
    //                 document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true)); // For 'otherReasonDropdown'

    //                 // Populate the reason dropdowns with actual options
    //                 reasons.forEach(reason => {
    //                     // Create option elements for each dropdown
    //                     const optionIn = document.createElement('option');
    //                     optionIn.value = reason.ReasonId;
    //                     optionIn.textContent = reason.reason_name;
    //                     document.getElementById('reasonInDropdown').appendChild(optionIn);

    //                     const optionOut = document.createElement('option');
    //                     optionOut.value = reason.ReasonId;
    //                     optionOut.textContent = reason.reason_name;
    //                     document.getElementById('reasonOutDropdown').appendChild(optionOut);

    //                     const optionOther = document.createElement('option');
    //                     optionOther.value = reason.ReasonId;
    //                     optionOther.textContent = reason.reason_name;
    //                     document.getElementById('otherReasonDropdown').appendChild(optionOther);
    //                 });

    //                 // Ensure "Select Option" is selected initially in all dropdowns
    //                 document.getElementById('reasonInDropdown').value = ''; // Select the default option
    //                 document.getElementById('reasonOutDropdown').value = ''; // Select the default option
    //                 document.getElementById('otherReasonDropdown').value = ''; // Select the default option
    //             })


    //             .catch(error => console.error('Error fetching reasons:', error));

    //         let inConditionMet = false;
    //         let outConditionMet = false;
    //         if (innTime === outTime) {
    //             remarkInGroup.style.display = 'none';
    //             reasonInGroup.style.display = 'none';
    //             remarkOutGroup.style.display = 'none';
    //             reasonOutGroup.style.display = 'none';
    //             document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
    //             document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input

    //         }
    //         else {
    //             // Your existing time condition logic...
    //             if (innTime > II) {
    //                 remarkInGroup.style.display = 'block';
    //                 reasonInGroup.style.display = 'block';
    //                 // document.getElementById('remarkIn').value = 'Your remark for late in';
    //                 inConditionMet = true;
    //             }
    //             if (outTime == '00:00') {
    //                 remarkOutGroup.style.display = 'block';
    //                 reasonOutGroup.style.display = 'block';
    //                 // document.getElementById('remarkOut').value = 'Your remark for early out';
    //                 document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
    //                 document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

    //             }

    //             if (outTime < OO) {
    //                 remarkOutGroup.style.display = 'block';
    //                 reasonOutGroup.style.display = 'block';
    //                 // document.getElementById('remarkOut').value = 'Your remark for early out';
    //                 outConditionMet = true;
    //             }

    //             // If both conditions are met, display both groups
    //             if (inConditionMet && outConditionMet) {
    //                 remarkInGroup.style.display = 'block';
    //                 reasonInGroup.style.display = 'block';
    //                 remarkOutGroup.style.display = 'block';
    //                 reasonOutGroup.style.display = 'block';
    //                 document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
    //                 document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

    //             }
    //         }
    //         const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
    //         modal.show();
    //     }
    // });

    document.addEventListener('click', function (event) {
        if (event.target.closest('.open-modal')) {
            event.preventDefault();

            const link = event.target.closest('.open-modal');
            const employeeId = link.getAttribute('data-employee-id');
            const date = link.getAttribute('data-date');
            const innTime = link.getAttribute('data-inn');
            const outTime = link.getAttribute('data-out');
            const II = link.getAttribute('data-II');
            const OO = link.getAttribute('data-OO');
            const atct = link.getAttribute('data-atct');
            const dataexist = link.getAttribute('data-exist');
            const status = link.getAttribute('data-status');
            const draft = link.getAttribute('data-draft');
            // Determine classes based on conditions
            const lateClass = (innTime > II) ? 'text-danger' : '';
            const earlyClass = (outTime < OO) ? 'text-danger' : '';
            // // Initialize content for request-date
            // if (dataexist === 'true') {
            //     // Select the modal footer and hide it
            //     const modalFooter = document.getElementById('modal-footer');
            //     console.log(modalFooter)
            //     if (modalFooter) {
            //         modalFooter.style.display = 'none';
            //     }
            // }
            // Initialize content for request-date
            let requestDateContent = `
                    <div style="text-align: left;">
                        <b>Request Date: ${date}</b>
                        <span style="color: ${draft === '3' || draft === null ? 'red' : (status === '1' ? 'green' : 'red')}; float: right; ${draft === '0' ? 'display: none;' : ''}">
                            <b style="color: black; font-weight: bold;">Status:</b> 
                            ${draft === '3' || draft === null ? 'Draft' : (status === '1' ? 'Approved' : 'Rejected')}
                        </span>
                    </div>
                `;

            // Check conditions for In
            if (innTime > II) {
                requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
            } else if (innTime <= II) {
                requestDateContent += `In: <span>${innTime}On Time</span><br>`; // Optional: show "On Time" if needed
            }

            // Check conditions for Out
            if (outTime < OO) {
                requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
            } else if (outTime >= OO) {
                requestDateContent += `Out: <span>${outTime}On Time</span>`; // Optional: show "On Time" if needed
            }

            // Set innerHTML only if there is content to display
            document.getElementById('request-date').innerHTML = requestDateContent;

            document.getElementById('employeeid').value = employeeId;
            document.getElementById('Atct').value = atct;
            document.getElementById('requestDate').value = date;

            // Clear previous values and hide all groups
            document.getElementById('remarkIn').value = '';
            document.getElementById('remarkOut').value = '';
            // document.getElementById('reasonInDropdown').innerHTML = '';
            // document.getElementById('reasonOutDropdown').innerHTML = '';

            document.getElementById('reasonInGroup').style.display = 'none';
            document.getElementById('remarkInGroup').style.display = 'none';
            document.getElementById('reasonOutGroup').style.display = 'none';
            document.getElementById('remarkOutGroup').style.display = 'none';
            document.getElementById('inreasonreqGroup').style.display = 'none';
            document.getElementById('reportingremarkreqGroup').style.display = 'none';
            document.getElementById('outreasonreqGroup').style.display = 'none';
            document.getElementById('reasonreqGroup').style.display = 'none';
            document.getElementById('otherRemarkGroup').style.display = 'none';
            document.getElementById('otherReasonGroup').style.display = 'none';


            const sendButton = document.getElementById('sendButton');
            sendButton.removeAttribute('disabled'); // Enable the button
            // Initially, make the 'otherRemark' input editable
            const otherRemarkInput = document.getElementById('otherRemark');
            otherRemarkInput.removeAttribute('readonly'); // Make the input editable

            const remarkOutInput = document.getElementById('remarkOut');
            remarkOutInput.removeAttribute('readonly'); // Make the input editable

            const remarkInInput = document.getElementById('remarkIn');
            remarkInInput.removeAttribute('readonly'); // Make the input editable

            // Fetch attendance data for this employee and date
            fetch(`/getAttendanceData?employeeId=${employeeId}&date=${date}`)
                .then(response => response.json())
                .then(attendanceData => {
                    // If attendance data is found for the given date
                    if (attendanceData) {
                        const attDate = new Date(attendanceData.attendance.AttDate); // Parse the date string into a Date object

                        // Format the date to day-MonthName-year (e.g., 6-November-2024)
                        const day = attDate.getDate(); // Get the day (6)
                        const month = attDate.toLocaleString('default', { month: 'long' }); // Get the month name (November)
                        const year = attDate.getFullYear(); // Get the year (2024)

                        const formattedDate = `${day}-${month}-${year}`; // Combine them into the desired format

                        // Dynamically set the request date and status section
                        let requestDateContent = `
                                <div style="text-align: left;">
                                    <b>Request Date: ${formattedDate}</b>
                                    <span style="color: ${attendanceData.attendance.draft_status === 3 ? 'red' : (attendanceData.attendance.Status === 1 ? 'green' : 'red')}; float: right;">
                                        <b style="color: black; font-weight: bold;">Status:</b> 
                                        ${attendanceData.attendance.draft_status === 3 ? 'Draft' :
                                (attendanceData.attendance.Status === 1 ? 'Approved' : 'Rejected')}
                                    </span>
                                </div>
                            `;
                        // Check conditions for In
                        if (innTime > II) {
                            requestDateContent += `In: <span class="${lateClass}">${innTime} Late</span><br>`;
                        } else if (innTime <= II) {
                            requestDateContent += `In: <span>${innTime}On Time</span><br>`; // Optional: show "On Time" if needed
                        }

                        // Check conditions for Out
                        if (outTime < OO) {
                            requestDateContent += `Out: <span class="${earlyClass}">${outTime} Early</span>`;
                        } else if (outTime >= OO) {
                            requestDateContent += `Out: <span>${outTime}On Time</span>`; // Optional: show "On Time" if needed
                        }

                        // Set innerHTML only if there is content to display
                        document.getElementById('request-date').innerHTML = requestDateContent;
                        // document.getElementById('attendanceMessage').style.display = 'block';

                        // If 'remarkIn' is available in the data, show the value instead of input
                        if (attendanceData.attendance.InRemark) {
                            console.log(attendanceData.attendance.InRemark);
                            const remarkInInput = document.getElementById('remarkIn');
                            remarkInInput.value = attendanceData.attendance.InRemark; // Fill in the remark value
                            remarkInInput.setAttribute('readonly', true); // Make it readonly
                            // Disable the 'Send' button
                            const sendButton = document.getElementById('sendButton');
                            sendButton.setAttribute('disabled', true); // Disable the button
                        }

                        // If 'remarkOut' is available in the data, show the value instead of input
                        if (attendanceData.attendance.OutRemark) {
                            const remarkOutInput = document.getElementById('remarkOut');
                            remarkOutInput.value = attendanceData.attendance.OutRemark; // Fill in the remark value
                            remarkOutInput.setAttribute('readonly', true); // Make it readonly
                            // Disable the 'Send' button
                            const sendButton = document.getElementById('sendButton');
                            sendButton.setAttribute('disabled', true); // Disable the button
                        }

                        // If 'remark' is available in the data, show the value instead of input
                        if (attendanceData.attendance.Remark) {
                            const otherRemarkInput = document.getElementById('otherRemark');
                            otherRemarkInput.value = attendanceData.attendance.Remark; // Fill in the remark value                                        
                            otherRemarkInput.setAttribute('readonly', true); // Make it readonly
                            // Disable the 'Send' button
                            const sendButton = document.getElementById('sendButton');
                            sendButton.setAttribute('disabled', true); // Disable the button
                        }

                        // If 'rep remark' is available in the data, show the value instead of input
                        if (attendanceData.attendance.R_Remark) {
                            const reporemarkkInput = document.getElementById('reportingremarkreq');
                            reporemarkkInput.value = attendanceData.attendance.R_Remark; // Fill in the remark value                                        
                            reporemarkkInput.setAttribute('readonly', true); // Make it readonly
                            // Disable the 'Send' button
                            const sendButton = document.getElementById('sendButton');
                            sendButton.setAttribute('disabled', true); // Disable the button
                        }

                        // If reasons for In/Out exist, show the value directly
                        if (attendanceData.attendance.InReason) {
                            document.getElementById('reasonInGroup').style.display = 'none'; // Hide dropdown
                            const reasonInInput = document.getElementById('inreasonreq');
                            reasonInInput.value = attendanceData.attendance.InReason; // Fill in the reason value
                            reasonInInput.setAttribute('readonly', true); // Make it readonly
                            // Disable the 'Send' button
                            const sendButton = document.getElementById('sendButton');
                            sendButton.setAttribute('disabled', true); // Disable the button

                        }

                        if (attendanceData.attendance.OutReason) {
                            document.getElementById('reasonOutGroup').style.display = 'none'; // Hide dropdown
                            const reasonOutInput = document.getElementById('outreasonreq');
                            reasonOutInput.value = attendanceData.attendance.OutReason; // Fill in the reason value
                            reasonOutInput.setAttribute('readonly', true); // Make it readonly

                        }

                        // If there is an "other" reason, show it instead of the dropdown
                        if (attendanceData.attendance.Reason) {
                            document.getElementById('otherReasonGroup').style.display = 'none'; // Hide dropdown
                            const otherReasonInput = document.getElementById('reasonreq');
                            otherReasonInput.value = attendanceData.attendance.Reason; // Fill in the reason value
                            otherReasonInput.setAttribute('readonly', true); // Make it readonly
                            // Disable the 'Send' button
                            const sendButton = document.getElementById('sendButton');
                            sendButton.setAttribute('disabled', true); // Disable the button

                        }

                        // Show additional fields if necessary based on the conditions
                        if (attendanceData.attendance.InReason) {
                            document.getElementById('inreasonreqGroup').style.display = 'block'; // Show In Reason Request
                        }
                        if (attendanceData.attendance.R_Remark) {
                            document.getElementById('reportingremarkreqGroup').style.display = 'block'; // Show In Reason Request
                        }

                        if (attendanceData.attendance.OutReason) {
                            document.getElementById('outreasonreqGroup').style.display = 'block'; // Show Out Reason Request
                        }

                        if (attendanceData.attendance.Reason) {
                            document.getElementById('reasonreqGroup').style.display = 'block'; // Show Other Reason Request
                        }

                    }

                    // else {

                    //     console.log('else');

                    //     // No attendance data available, show default behavior (dropdowns)
                    //     document.getElementById('remarkInGroup').style.display = 'block';
                    //     document.getElementById('remarkOutGroup').style.display = 'block';
                    //     document.getElementById('reasonInGroup').style.display = 'block';
                    //     document.getElementById('reasonOutGroup').style.display = 'block';
                    //     document.getElementById('otherReasonGroup').style.display = 'block';
                    //     document.getElementById('otherRemarkGroup').style.display = 'block';

                    // }
                })
                .catch(error => {
                    console.error('Error fetching attendance data:', error);
                });

            // Fetch company_id and department_id based on employeeId
            fetch(`/api/getEmployeeDetails/${employeeId}`)
                .then(response => response.json())
                .then(data => {
                    const companyId = data.company_id;
                    const departmentId = data.department_id;

                    // Fetch reasons based on companyId and departmentId
                    return fetch(`/api/getReasons/${companyId}/${departmentId}`);
                })
                .then(response => response.json())
                .then(reasons => {
                    // Function to clear existing options in the dropdowns
                    function clearDropdown(dropdownId) {
                        const dropdown = document.getElementById(dropdownId);
                        dropdown.innerHTML = '';
                    }

                    // Clear existing options in all dropdowns
                    clearDropdown('reasonInDropdown');
                    clearDropdown('reasonOutDropdown');
                    clearDropdown('otherReasonDropdown');

                    // Add default "Select Option" as the first option for each dropdown
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';  // empty value for "Select Option"
                    defaultOption.textContent = 'Select Reason';

                    document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true));
                    document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true));
                    document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true));

                    // Populate the reason dropdowns with actual options
                    reasons.forEach(reason => {
                        const optionIn = document.createElement('option');
                        optionIn.value = reason.ReasonId;
                        optionIn.textContent = reason.reason_name;
                        document.getElementById('reasonInDropdown').appendChild(optionIn);

                        const optionOut = document.createElement('option');
                        optionOut.value = reason.ReasonId;
                        optionOut.textContent = reason.reason_name;
                        document.getElementById('reasonOutDropdown').appendChild(optionOut);

                        const optionOther = document.createElement('option');
                        optionOther.value = reason.ReasonId;
                        optionOther.textContent = reason.reason_name;
                        document.getElementById('otherReasonDropdown').appendChild(optionOther);
                    });

                    // Ensure "Select Option" is selected initially in all dropdowns
                    document.getElementById('reasonInDropdown').value = '';
                    document.getElementById('reasonOutDropdown').value = '';
                    document.getElementById('otherReasonDropdown').value = '';
                })
                .catch(error => console.error('Error fetching reasons:', error));

            // // Fetch company_id and department_id based on employeeId
            // fetch(`/api/getEmployeeDetails/${employeeId}`)
            //     .then(response => response.json())
            //     .then(data => {
            //         const companyId = data.company_id;
            //         const departmentId = data.department_id;

            //         // Fetch reasons based on companyId and departmentId
            //         return fetch(`/api/getReasons/${companyId}/${departmentId}`);
            //     })
            //     .then(response => response.json())
            //     .then(reasons => {
            //         // Function to clear existing options in the dropdowns
            //         function clearDropdown(dropdownId) {
            //             const dropdown = document.getElementById(dropdownId);
            //             // Clear all existing options
            //             dropdown.innerHTML = '';
            //         }

            //         // Clear existing options in all dropdowns
            //         clearDropdown('reasonInDropdown');
            //         clearDropdown('reasonOutDropdown');
            //         clearDropdown('otherReasonDropdown');

            //         // Add default "Select Option" as the first option for each dropdown
            //         const defaultOption = document.createElement('option');
            //         defaultOption.value = '';  // empty value for "Select Option"
            //         defaultOption.textContent = 'Select Reason';

            //         document.getElementById('reasonInDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonInDropdown'
            //         document.getElementById('reasonOutDropdown').appendChild(defaultOption.cloneNode(true)); // For 'reasonOutDropdown'
            //         document.getElementById('otherReasonDropdown').appendChild(defaultOption.cloneNode(true)); // For 'otherReasonDropdown'

            //         // Populate the reason dropdowns with actual options
            //         reasons.forEach(reason => {
            //             // Create option elements for each dropdown
            //             const optionIn = document.createElement('option');
            //             optionIn.value = reason.ReasonId;
            //             optionIn.textContent = reason.reason_name;
            //             document.getElementById('reasonInDropdown').appendChild(optionIn);

            //             const optionOut = document.createElement('option');
            //             optionOut.value = reason.ReasonId;
            //             optionOut.textContent = reason.reason_name;
            //             document.getElementById('reasonOutDropdown').appendChild(optionOut);

            //             const optionOther = document.createElement('option');
            //             optionOther.value = reason.ReasonId;
            //             optionOther.textContent = reason.reason_name;
            //             document.getElementById('otherReasonDropdown').appendChild(optionOther);
            //         });

            //         // Ensure "Select Option" is selected initially in all dropdowns
            //         document.getElementById('reasonInDropdown').value = ''; // Select the default option
            //         document.getElementById('reasonOutDropdown').value = ''; // Select the default option
            //         document.getElementById('otherReasonDropdown').value = ''; // Select the default option
            //     })

            //     // .then(reasons => {
            //     //     // Populate the reason dropdowns
            //     //     reasons.forEach(reason => {
            //     //         const optionIn = document.createElement('option');
            //     //         optionIn.value = reason.ReasonId;
            //     //         optionIn.textContent = reason.reason_name;
            //     //         document.getElementById('reasonInDropdown').appendChild(optionIn);

            //     //         const optionOut = document.createElement('option');
            //     //         optionOut.value = reason.ReasonId;
            //     //         optionOut.textContent = reason.reason_name;
            //     //         document.getElementById('reasonOutDropdown').appendChild(optionOut);

            //     //         const optionOther = document.createElement('option');
            //     //         optionOther.value = reason.ReasonId;
            //     //         optionOther.textContent = reason.reason_name;
            //     //         document.getElementById('otherReasonDropdown').appendChild(optionOther);
            //     //     });
            //     // })
            //     .catch(error => console.error('Error fetching reasons:', error));

            let inConditionMet = false;
            let outConditionMet = false;
            if (innTime === outTime) {
                remarkInGroup.style.display = 'none';
                reasonInGroup.style.display = 'none';
                remarkOutGroup.style.display = 'none';
                reasonOutGroup.style.display = 'none';
                document.getElementById('otherReasonGroup').style.display = 'block'; // Show Other Reason dropdown
                document.getElementById('otherRemarkGroup').style.display = 'block'; // Show Other Remark input

            }
            else {
                // Your existing time condition logic...
                if (innTime > II) {
                    remarkInGroup.style.display = 'block';
                    reasonInGroup.style.display = 'block';
                    // document.getElementById('remarkIn').value = 'Your remark for late in';
                    inConditionMet = true;
                }
                if (outTime == '00:00') {
                    remarkOutGroup.style.display = 'block';
                    reasonOutGroup.style.display = 'block';
                    // document.getElementById('remarkOut').value = 'Your remark for early out';
                    document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                    document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

                }

                if (outTime < OO) {
                    remarkOutGroup.style.display = 'block';
                    reasonOutGroup.style.display = 'block';
                    // document.getElementById('remarkOut').value = 'Your remark for early out';
                    outConditionMet = true;
                }

                // If both conditions are met, display both groups
                if (inConditionMet && outConditionMet) {
                    remarkInGroup.style.display = 'block';
                    reasonInGroup.style.display = 'block';
                    remarkOutGroup.style.display = 'block';
                    reasonOutGroup.style.display = 'block';
                    document.getElementById('otherReasonGroup').style.display = 'none'; // Show Other Reason dropdown
                    document.getElementById('otherRemarkGroup').style.display = 'none'; // Show Other Remark input

                }
            }
            const modal = new bootstrap.Modal(document.getElementById('AttendenceAuthorisation'));
            modal.show();
        }
    });


    document.getElementById('reasonInDropdown').addEventListener('change', function () {
        const selectedIn = this.value;
        const selectedOut = document.getElementById('reasonOutDropdown').value;

        // If an "In" reason is selected, check if an "Out" reason is selected
        if (selectedIn && selectedOut) {
            // You could choose to prevent changing or notify the user here if needed
            console.log('Both reasons are selected, no changes made.');
        }
    });

    document.getElementById('reasonOutDropdown').addEventListener('change', function () {
        const selectedOut = this.value;
        const selectedIn = document.getElementById('reasonInDropdown').value;

        // If an "Out" reason is selected, check if an "In" reason is selected
        if (selectedIn && selectedOut) {
            // You could choose to prevent changing or notify the user here if needed
            console.log('Both reasons are selected, no changes made.');
        }
    });

    document.getElementById('sendButton').addEventListener('click', function () {
        const form = document.getElementById('attendanceForm');

        // Use Fetch API to submit the form
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token
            }
        })
            .then(response => response.json())
            .then(data => {
                const responseMessage = document.getElementById('responseMessage');

                // Set the message text
                responseMessage.innerText = data.message;

                // Show the message box
                responseMessage.style.display = 'block';

                if (data.success) {
                    // Apply the success class (green)
                    responseMessage.classList.remove('text-danger'); // Remove danger class if present
                    responseMessage.classList.add('text-success'); // Add success class for green
                    // Delay the modal closing and form reset by 5 seconds
                    setTimeout(function () {
                        $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 5 seconds
                        $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form (if applicable)
                        responseMessage.style.display = 'none'; // Hide the response message

                    }, 2000); // 5000 milliseconds = 5 seconds
                } else {
                    // Apply the danger class (red) for errors
                    responseMessage.classList.remove('text-success'); // Remove success class if present
                    responseMessage.classList.add('text-danger'); // Add danger class for red
                    setTimeout(function () {
                        $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form (if applicable)
                        responseMessage.style.display = 'none'; // Hide the response message

                    }, 2000); // 5000 milliseconds = 5 seconds
                }
            })

            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the request.');
            });
    });

    function fetchAttendanceData(selectedMonth, year) {
        const monthNumber = monthNames.indexOf(selectedMonth) + 1;
        const employeeId =employeeId;

        cardHeaders.forEach(header => {
            header.textContent = `${selectedMonth} ${year}`;
        });
        if (late_card_header) {
            late_card_header.textContent = `Late List ${selectedMonth} ${year}`;
        }

        fetch(`/attendance/${year}/${monthNumber}/${employeeId}`)
            .then(response => response.json())
            .then(data => {
                const calendar = document.querySelector('.calendar tbody');
                calendar.innerHTML = '';

                const daysInMonth = new Date(year, monthNumber, 0).getDate();
                const firstDayOfMonth = new Date(year, monthNumber - 1, 1).getDay();

                let currentRow = document.createElement('tr');
                let latenessCount = 0;


                // Get the lateness container
                const latenessContainer = document.querySelector('.late-atnd');
                latenessContainer.innerHTML = ''; // Clear previous lateness data

                // Fill empty cells for the first week
                for (let i = 0; i < firstDayOfMonth; i++) {
                    const emptyCell = document.createElement('td');
                    emptyCell.classList.add('day');
                    currentRow.appendChild(emptyCell);
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const dayData = data.find(record => {
                        const recordDate = new Date(record.AttDate);
                        return recordDate.getDate() === day && recordDate.getMonth() + 1 === monthNumber;
                    });

                    const cell = document.createElement('td');
                    cell.classList.add('day');
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison
                    // Determine if the day is a Sunday
                    const currentDate = new Date(year, monthNumber - 1, day);
                    if (currentDate.getDay() === 0) { // 0 is Sunday
                        cell.style.backgroundColor = 'rgb(209,243,174)';
                        cell.innerHTML = `<div class="day-num">${day}</div>`; // Just show the day number
                    }
                    else {
                        if (dayData) {
                            const attValue = dayData.AttValue;
                            const innTime = dayData.Inn;
                            const iiTime = dayData.II;
                            console.log(dayData);

                            let Atct = 0; // Initialize Atct
                            if (dayData.InnLate == 1 && dayData.OuttLate == 0) {
                                Atct = 1;
                            } else if (dayData.InnLate == 0 && dayData.OuttLate == 1) {
                                Atct = 2;
                            } else if (dayData.InnLate == 1 && dayData.OuttLate == 1) {
                                Atct = 12;
                            } else if ((dayData.InnLate == 0 || dayData.InnLate === '') && (dayData.OuttLate == 0 || dayData['OuttLate'] === '')) {
                                Atct = 3;
                            }
                            let latenessStatus = '';

                            // Assuming this logic is part of a loop or multiple data checks
                            // Check if there's lateness data to append
                            if (innTime > iiTime || dayData.Outt < dayData.OO) {
                                latenessCount++;
                                latenessStatus = `L${latenessCount}`;

                                // Determine if we need to add the "danger" class
                                const punchInDanger = innTime > iiTime ? 'danger' : '';
                                const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';

                                // Determine the status label and set up the modal link if needed
                                let statusLabel = '';
                                let modalLink = '';

                                if (dayData.Status === 0) {
                                    statusLabel = 'Request';
                                    modalLink = `
                                        <a href="#" class="open-modal" 
                                        data-date="${day}-${monthNames[monthNumber - 1]}-${year}" 
                                        data-inn="${innTime}" 
                                        data-out="${dayData.Outt}" 
                                        data-ii="${dayData.II}" 
                                        data-oo="${dayData.OO}" 
                                        data-atct="${Atct}" 
                                        data-status="${dayData.Status}" 
                                        data-employee-id="${employeeId}">
                                            ${statusLabel}
                                        </a>`;
                                } else if (dayData.Status === 1) {
                                    statusLabel = 'Approved';
                                }

                                // Append the lateness data as usual
                                latenessContainer.innerHTML += `
                                        <div class="late-atnd">
                                            <div>
                                                <span class="late-l1">${latenessStatus}</span>
                                                <h6 class="float-start mt-2">${day} ${monthNames[monthNumber - 1]} ${year}</h6>
                                                <div class="float-end mt-1">
                                                    <label style="padding:6px 13px;font-size: 11px;" class="mb-0 sm-btn btn-outline success-outline" title="${statusLabel}">
                                                        ${dayData.Status === 0 ? modalLink : statusLabel}
                                                    </label>
                                                </div>
                                            </div>
                                            <div style="color:#777171; float: left; width: 100%; margin-top:5px;">
                                                <span class="float-start">Punch in <span class="${punchInDanger}"><b>${innTime}</b></span></span>
                                                <span class="float-end">Punch Out <span class="${punchOutDanger}"><b>${dayData.Outt || '00:00'}</b></span></span>
                                            </div>
                                        </div>
                                        `;
                            }

                            // If no lateness data was added, show the "No Late Data" message
                            if (latenessContainer.innerHTML.trim() === '') {
                                latenessContainer.innerHTML = `<b class="float-start mt-2 no-late-data">No Late Data</b>`;
                            } else {
                                // Add a class to hide the "No Late Data" message when data is present
                                const noLateDataMessage = document.querySelector('.no-late-data');
                                if (noLateDataMessage) {
                                    noLateDataMessage.style.display = 'none';
                                }
                            }


                            // Icon logic
                            let iconHtml = '';
                            const today = new Date();
                            const isCurrentMonth = monthNumber === today.getMonth() + 1;
                            const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month

                            if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                if (dayData.Inn > dayData.II || dayData.Outt < dayData.OO || dayData.Inn === dayData.Outt) {
                                    iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;
                                }
                            }

                            // Append iconHtml to your cell if needed
                            if (iconHtml) {
                                cell.innerHTML += iconHtml;
                            }
                            let attenBoxContent = '';
                            if (latenessStatus && dayData.Status === 0) {
                                attenBoxContent += `<span class="atte-late">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                            }

                            if (latenessStatus && dayData.Status === 1) {
                                // If status is 1 and latenessStatus already shown, do not add it again
                                if (!attenBoxContent.includes(latenessStatus)) {
                                    attenBoxContent += `<span class="atte-late-status">${latenessStatus}</span>`; // Add lateness status to the calendar cell
                                }
                            }
                            draft = (dayData.DraftStatus === null || dayData.DraftStatus === "null" || dayData.DraftStatus === "") ? 0 : Number(dayData.DraftStatus);


                            switch (attValue) {
                                case 'P':
                                    attenBoxContent += `<span class="atte-present">P</span>`;
                                    attenBoxContent += `
                                    <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" 
                                    data-employee-id="${employeeId}" data-exist="${dayData.DataExist}"data-status="${dayData.Status}" data-draft="${draft}">
                                         ${iconHtml}
                                    </a>
                                `;
                                    break;
                                case 'A':
                                    attenBoxContent += `<span class="atte-absent">A</span>`;
                                    break;
                                case 'HO':
                                    attenBoxContent += `<span class="holiday-cal">${attValue}</span>`;
                                    break;
                                case 'OD':
                                    attenBoxContent += `<span class="atte-OD">${attValue}</span>`;
                                    break;
                                case 'PH':
                                case 'CH':
                                case 'SH':
                                case 'PL':
                                case 'FL':
                                case 'SL':
                                case 'CL':
                                case 'EL':
                                    attenBoxContent += `<span class="atte-all-leave">${attValue}</span>`;
                                    break;
                                default:
                                    attenBoxContent += `
                                    <span class="atte-present"></span>
                                    <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="${innTime}" data-out="${dayData.Outt}" data-ii="${dayData.II}" data-oo="${dayData.OO}" data-atct="${Atct}" data-employee-id="${employeeId}">
                                         ${iconHtml}
                                    </a>
                                `;
                                    break;
                            }


                            const punchInDanger = dayData.Inn > dayData.II ? 'danger' : '';
                            const punchOutDanger = dayData.OO > dayData.Outt ? 'danger' : '';

                            cell.innerHTML = `
                                <div class="day-num">${day}</div>
                                <div class="punch-section">
                                    <span class="${punchInDanger}"><b>In:</b> ${innTime || '00:00'}</span><br>
                                    <span class="${punchOutDanger}"><b>Out:</b> ${dayData.Outt || '00:00'}</span>
                                </div>
                                <div class="atten-box">${attenBoxContent}</div>
                            `;
                        }
                        else {
                            const today = new Date();
                            today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

                            let iconHtml = '';
                            const isCurrentMonth = monthNumber === today.getMonth() + 1;
                            const isLastMonth = monthNumber === today.getMonth(); // Check if it's the last month

                            if (!(isCurrentMonth && (day > daysInMonth - 2)) && !isLastMonth) { // Last two days of current month or last month
                                iconHtml = `<i class="fas fa-plus-circle primary calender-icon"></i>`;


                            }
                            cell.innerHTML = `
                            <div class="day-num">${day}</div>
                            <div class="atten-box">
                                <a href="#" class="open-modal" data-date="${day}-${monthNames[monthNumber - 1]}-${year}" data-inn="00:00" data-out="00:00" data-ii="00:00" data-oo="00:00" data-atct="3" data-employee-id="${employeeId}"data-draft="0">
                                         ${iconHtml}
                                </a></div>`;

                        }
                    }

                    currentRow.appendChild(cell);

                    if ((firstDayOfMonth + day) % 7 === 0) {
                        calendar.appendChild(currentRow);
                        currentRow = document.createElement('tr');
                    }
                }

                if (currentRow.childElementCount > 0) {
                    calendar.appendChild(currentRow);
                }
            })
            .catch(error => console.error('Error fetching attendance data:', error));
    }

});

$(document).ready(function () {
// Check if there's an active tab stored in sessionStorage
const activeTab = sessionStorage.getItem('activeTab');
console.log("Stored Active Tab:", activeTab); // Log to verify if the active tab is being stored

// If there's a stored active tab, activate it after page reload
if (activeTab) {
$('#myTab1 a[href="' + activeTab + '"]').tab('show');
}

// Event listener for tab clicks (store the active tab href when clicked)
$('#myTab1 a').on('click', function (e) {
// Store the href of the clicked tab in sessionStorage
const activeTab = $(this).attr('href');
sessionStorage.setItem('activeTab', activeTab);
console.log("Storing activeTab:", activeTab); // Log the href being stored
});

// Handle form submission (AJAX)
$('#leaveForm').on('submit', function (e) {
e.preventDefault(); // Prevent default form submission

// Store the active tab before submitting the form
const activeTab = $('#myTab1 .nav-link.active').attr('href');
sessionStorage.setItem('activeTab', activeTab);
console.log("Storing active tab before submit:", activeTab);

// Form submission logic
const url = $(this).attr('action');
$.ajax({
    url: url,
    type: 'POST',
    data: $(this).serialize(), // Serialize form data
    success: function (response) {
        $('#leaveMessage').show(); // Show the message div
        if (response.success) {
            $('#leaveMessage').removeClass('alert-danger').addClass('alert-success')
                .text('Form submitted successfully!').show();
            // Reload the page after 1 second
            setTimeout(function () {
                location.reload(); // Reload the page
            }, 1000);
        } else {
            $('#leaveMessage').removeClass('alert-success').addClass('alert-danger')
                .text(response.message).show();
        }
    },
    error: function (xhr, status, error) {
        $('#leaveMessage').removeClass('alert-success').addClass('alert-danger')
            .text('An error occurred: ' + error).show();
    }
});
});
});

$(document).ready(function () {
    $('#AttendenceAuthorisation').on('hidden.bs.modal', function () {
        $('#AttendenceAuthorisation').modal('hide');  // Close the modal after 5 seconds
        $('#AttendenceAuthorisation').find('form')[0].reset();  // Reset the form (if applicable)
    });
});
function validatePhoneNumber(input) {
// Ensure only numeric input and limit the input to 12 digits
input.value = input.value.replace(/[^0-9]/g, '').slice(0, 12);
}
