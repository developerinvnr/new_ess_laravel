<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header align-items-center d-flex p-2">
                <ol class="breadcrumb m-0 flex-grow-1">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Type</a></li>
                    <li class="breadcrumb-item active">Activity</li>
                </ol>
                <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#AddTranModal"><i class="ri-add-line align-bottom me-1"></i> Add New Activity</button>
                <div class="flex-shrink-0" style="font-size:16px;">
                    <a class="me-2" href=""><i class="las la-file-pdf"></i></a>
                    <a class="me-2" href=""><i class="las la-file-excel"></i></a>
                    <a class="me-2" href=""><i class="las la-file-csv"></i></a>
                </div>
            </div><!-- end card header -->

            <div class="card-body table-responsive">
                <table id="companytable" class="table text-center table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                    <thead>
                        <tr>

                            <th rowspan="2">SR No.</th>
                            <th rowspan="2">Name</th>
                            <th rowspan="2">Approve</th>
                            <th rowspan="2">Reject</th>
                            <th colspan="5">Module</th>
                            <th rowspan="2">Notification</th>
                            <th rowspan="2">Status</th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th>Workflow</th>
                            <th>Trigger</th>
                            <th>Notification</th>
                            <th>Report</th>
                            <th>Transaction</th>
                        </tr>
                    </thead>
                    <div id="activityAlertContainerSuccess" class="mb-3">
                    </div>
                    <tbody id="activitiesTableBody">
                        @foreach($activities as $activity)
                           <tr data-id="{{ $activity->id }}">

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $activity->name }}</td>
                                <td>{{ $activity->approve }}</td>
                                <td>{{ $activity->reject }}</td>
                                <td>
                                    @if(in_array('Workflow', $activity->modules ?? []))
                                        <i class="ri-checkbox-circle-line text-success"></i> @else
                                        <i class="ri-close-circle-line text-danger"></i>   @endif
                                </td>
                                <td>
                                    @if(in_array('Trigger', $activity->modules ?? []))
                                        <i class="ri-checkbox-circle-line text-success"></i>
                                    @else
                                        <i class="ri-close-circle-line text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if(in_array('Notification', $activity->modules ?? []))
                                        <i class="ri-checkbox-circle-line text-success"></i>
                                    @else
                                        <i class="ri-close-circle-line text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if(in_array('Report', $activity->modules ?? []))
                                        <i class="ri-checkbox-circle-line text-success"></i>
                                    @else
                                        <i class="ri-close-circle-line text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    @if(in_array('Transaction', $activity->modules ?? []))
                                        <i class="ri-checkbox-circle-line text-success"></i>
                                    @else
                                        <i class="ri-close-circle-line text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                 @foreach($activity->notification_type ?? [] as $type)
                                    <span class="badge bg-primary me-1">{{ $type }}</span>
                                @endforeach
                                </td>
                                 <td>
                                    <span class="badge 
                                        {{ $activity->status === 'Active' 
                                            ? 'bg-success-subtle text-success' 
                                            : 'bg-danger-subtle text-danger' }}">
                                        {{ $activity->status }}
                                    </span>
                                </td>
                                 <td>
                                    <button class="btn btn-sm btn-link text-primary edit-btn"
                                            data-id="{{ $activity->id }}"
                                            data-name="{{ $activity->name }}"
                                            data-approve="{{ $activity->approve }}"
                                            data-reject="{{ $activity->reject }}"
                                            data-modules='@json($activity->modules)'
                                            data-notification_type='@json($activity->notification_type)'
                                            data-status="{{ $activity->status }}"
                                            title="Edit">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-link text-danger delete-btn" data-id="{{ $activity->id }}" title="Delete"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div>

<!-- ADD activity  Modal -->
<div class="modal fade" id="AddTranModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AddTranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="AddTranModalLabel">Add New Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                 <div id="modalAlertContainer" class="mb-3">
                    {{-- General error alerts will be inserted here --}}
                </div>
                <form id="activityForm">
                    <div class="row g-3">
                        <!-- Activity Name -->
                        <div class="col-md-6">
                            <label class="form-label">Activity Name</label>
                            <input type="text" class="form-control form-control-sm" name="name" required>
                        </div>

                        <!-- Approve -->
                        <div class="col-md-3">
                            <label class="form-label">Approve</label>
                            <select class="form-select form-select-sm" name="approve">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <!-- Reject -->
                        <div class="col-md-3">
                            <label class="form-label">Reject</label>
                            <select class="form-select form-select-sm" name="reject">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>

                        <!-- Module Checkboxes -->
                        <div class="col-md-12">
                            <label class="form-label d-block">Modules</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="modules[]" value="Workflow" id="workflowCheck">
                                <label class="form-check-label" for="workflowCheck">Workflow</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="modules[]" value="Trigger" id="triggerCheck">
                                <label class="form-check-label" for="triggerCheck">Trigger</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="modules[]" value="Notification" id="notificationCheck">
                                <label class="form-check-label" for="notificationCheck">Notification</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="modules[]" value="Report" id="reportCheck">
                                <label class="form-check-label" for="reportCheck">Report</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="modules[]" value="Transaction" id="transactionCheck">
                                <label class="form-check-label" for="transactionCheck">Transaction</label>
                            </div>
                        </div>

                        <!-- Notification Type -->
                        <div class="col-md-12">
                            <label class="form-label d-block">Notification Type</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_type[]" value="Email" id="EmailCheck">
                                <label class="form-check-label" for="EmailCheck">Email</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_type[]" value="SMS" id="SMSCheck">
                                <label class="form-check-label" for="SMSCheck">SMS</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="notification_type[]" value="InApp" id="InApp">
                                <label class="form-check-label" for="InApp">In App</label>
                            </div>

                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="activityForm" class="btn btn-sm btn-success">Submit</button>
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- EDIT activity  Modal -->
<div class="modal fade" id="EditTranModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditTranModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="EditTranModalLabel">Edit Activity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="font-family: roboto;">
        <form id="editActivityForm" method="POST" action="">
          @csrf
          <input type="hidden" name="id" id="edit_id">
          <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
              <label class="form-label">Activity Name</label>
              <input type="text" class="form-control form-control-sm" name="name" id="edit_name" required>
            </div>

            <!-- Approve -->
            <div class="col-md-3">
              <label class="form-label">Approve</label>
              <select class="form-select form-select-sm" name="approve" id="edit_approve">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>

            <!-- Reject -->
            <div class="col-md-3">
              <label class="form-label">Reject</label>
              <select class="form-select form-select-sm" name="reject" id="edit_reject">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
              </select>
            </div>

            <!-- Modules -->
            <div class="col-md-12">
              <label class="form-label d-block">Modules</label>
              @foreach(['Workflow', 'Trigger', 'Notification', 'Report', 'Transaction'] as $mod)
                <div class="form-check form-check-inline">
                  <input class="form-check-input edit-modules" type="checkbox" name="modules[]" value="{{ $mod }}" id="edit_{{ strtolower($mod) }}">
                  <label class="form-check-label" for="edit_{{ strtolower($mod) }}">{{ $mod }}</label>
                </div>
              @endforeach
            </div>

            <!-- Notification Types -->
            <div class="col-md-12">
              <label class="form-label d-block">Notification Type</label>
              @foreach(['Email', 'SMS', 'InApp'] as $ntype)
                <div class="form-check form-check-inline">
                  <input class="form-check-input edit-notify" type="checkbox" name="notification_type[]" value="{{ $ntype }}" id="edit_nt_{{ strtolower($ntype) }}">
                  <label class="form-check-label" for="edit_nt_{{ strtolower($ntype) }}">{{ $ntype }}</label>
                </div>
              @endforeach
            </div>

            <!-- Status -->
            <div class="col-md-6">
              <label class="form-label">Status</label>
              <select class="form-select form-select-sm" name="status" id="edit_status">
                <option value="Active">Active</option>
                <option value="Deactive">Deactive</option>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="submit" form="editActivityForm" class="btn btn-sm btn-success">Update</button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function() {
        // --- Helper Functions (remain mostly the same) ---
        function showPageAlert(message, type = 'success') {
            const alertContainer = $('#activityAlertContainerSuccess');
            alertContainer.empty(); // Clear any existing alerts

            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            alertContainer.append(alertHtml);

            // Optionally, hide the alert after a few seconds
            setTimeout(() => {
                alertContainer.find('.alert').alert('close');
            }, 5000);
        }

        // Helper function to display errors within a modal (now takes modal ID)
        function showModalErrors(errors, modalId = '#modalAlertContainer') {
            // Clear previous errors first
            $(`${modalId} .error-text`).text(''); // Clear field-specific error spans within the specific modal
            $(modalId).empty(); // Clear general modal alert

            if (typeof errors === 'string') {
                // If it's a general string error (e.g., 500 internal server error)
                const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${errors}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                $(modalId).append(alertHtml);
            } else if (typeof errors === 'object') {
                // If it's a validation errors object
                for (const field in errors) {
                    if (errors.hasOwnProperty(field)) {
                        // Display field-specific errors next to the field
                        $(`${modalId}`).closest('.modal-body').find(`span.${field}_error`).text(errors[field][0]);
                    }
                }
            }
        }

        function getModuleIcon(activityModules, moduleName) {
            const modulesArray = Array.isArray(activityModules) ? activityModules : [];
            if (modulesArray.includes(moduleName)) {
                return '<i class="ri-checkbox-circle-line text-success"></i>';
            } else {
                return '<i class="ri-close-circle-line text-danger"></i>';
            }
        }

        function getNotificationTypeBadges(notificationTypesArray) {
            let badgesHtml = [];
            const types = Array.isArray(notificationTypesArray) ? notificationTypesArray : [];
            types.forEach(type => {
                badgesHtml.push(`<span class="badge bg-primary me-1">${type}</span>`);
            });
            return badgesHtml.join('');
        }

        // Function to append a single new activity row
        function appendNewActivityRow(activity) {
            console.log(activity);
            const modules = Array.isArray(activity.modules) ? activity.modules : [];
            const notificationTypes = Array.isArray(activity.notification_type) ? activity.notification_type : [];

            const serialNumber = $('#activitiesTableBody tr').length + 1;

            $('#activitiesTableBody').append(`
                <tr data-id="${activity.id}">
                    <td>${serialNumber}</td>
                    <td>${activity.name}</td>
                    <td>${activity.approve}</td>
                    <td>${activity.reject}</td>
                    <td>${getModuleIcon(modules, 'Workflow')}</td>
                    <td>${getModuleIcon(modules, 'Trigger')}</td>
                    <td>${getModuleIcon(modules, 'Notification')}</td>
                    <td>${getModuleIcon(modules, 'Report')}</td>
                    <td>${getModuleIcon(modules, 'Transaction')}</td>
                    <td>${getNotificationTypeBadges(notificationTypes)}</td>
                    <td>
                    ${activity.status === 'Active'
                        ? '<span class="badge bg-success-subtle text-success">Active</span>'
                        : '<span class="badge bg-danger-subtle text-danger">Deactive</span>'}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-link text-primary edit-btn" data-id="${activity.id}" title="Edit"><i class="bx bx-pencil"></i></button>
                        <button class="btn btn-sm btn-link text-danger delete-btn" data-id="${activity.id}" title="Delete"><i class="bx bx-trash"></i></button>
                    </td>
                </tr>
            `);
        }

        // Function to update an existing activity row
        function updateActivityRow(activity) {
            // modules and notification_type are arrays already from the response
            const modules = Array.isArray(activity.modules) ? activity.modules : [];
            const notificationTypes = Array.isArray(activity.notification_type) ? activity.notification_type : [];

            const row = $(`#activitiesTableBody tr[data-id="${activity.id}"]`);

            if (row.length) {
                row.find('td:nth-child(2)').text(activity.name); // Name
                row.find('td:nth-child(3)').text(activity.approve); // Approve
                row.find('td:nth-child(4)').text(activity.reject); // Reject
                row.find('td:nth-child(5)').html(getModuleIcon(modules, 'Workflow')); // Workflow
                row.find('td:nth-child(6)').html(getModuleIcon(modules, 'Trigger')); // Trigger
                row.find('td:nth-child(7)').html(getModuleIcon(modules, 'Notification')); // Notification
                row.find('td:nth-child(8)').html(getModuleIcon(modules, 'Report')); // Report
                row.find('td:nth-child(9)').html(getModuleIcon(modules, 'Transaction')); // Transaction
                row.find('td:nth-child(10)').html(getNotificationTypeBadges(notificationTypes)); // Notification Type
                row.find('td:nth-child(11)').text(activity.status); // Status
            }
        }


        // --- Add New Activity Logic ---
        $('#activityForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            let modules = [];
            $('input[name="modules[]"]:checked').each(function() {
                modules.push($(this).val());
            });

            let notification_type = [];
            $('input[name="notification_type[]"]:checked').each(function() {
                notification_type.push($(this).val());
            });

            let dataToSend = {
                name: $('input[name="name"]').val(),
                approve: $('select[name="approve"]').val(),
                reject: $('select[name="reject"]').val(),
                modules: modules.join(','), // Send as comma-separated string
                notification_type: notification_type.join(','), // Send as comma-separated string
                status: $('select[name="status"]').val(),
            };

            $.ajax({
                url: '{{ route("activity.store") }}', // Your store route
                method: 'POST',
                data: dataToSend,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#AddTranModal').modal('hide');
                        $('#activityForm')[0].reset(); // Clear the form
                        // Clear validation errors specific to this form
                        $('#modalAlertContainer').empty();
                        $('#activityForm').find('.error-text').text('');

                        appendNewActivityRow(response.activity);
                        showPageAlert(response.message || 'Activity added successfully!', 'success');
                    } else {
                        showModalErrors(response.message || 'An unknown error occurred.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error adding activity:", xhr.responseText);
                    if (xhr.status === 422) {
                        showModalErrors(xhr.responseJSON.errors, '#modalAlertContainer');
                    } else {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'An error occurred while adding the activity. Please try again.';
                        showModalErrors(errorMessage, '#modalAlertContainer');
                    }
                }
            });
        });

        // --- Edit Activity Logic ---

        // Event listener for "Add New Activity" button to reset form
        $('#addNewActivityBtn').on('click', function() {
            $('#activityForm')[0].reset(); // Clear the add form
            $('#modalAlertContainer').empty(); // Clear any old alerts in the add modal
            $('#activityForm').find('.error-text').text(''); // Clear any old error texts
        });

        $(document).on('click', '.edit-btn', function () {
            const btn = $(this);
            const activityId = btn.data('id');

            // URL to fetch fresh activity data (make sure route name is correct)
            let url = '{{ route("activities.show", ":id") }}'.replace(':id', activityId);

            // Fetch fresh data via AJAX
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    const activity = response;
                    
                    // Set form action URL for update
                    let updateUrlTemplate = '{{ route("activity.update", ":id") }}';
                    let updateUrl = updateUrlTemplate.replace(':id', activityId);
                    $('#editActivityForm').attr('action', updateUrl);

                    // Fill form inputs with fresh data
                    $('#edit_id').val(activity.id);
                    $('#edit_name').val(activity.name);
                    $('#edit_approve').val(activity.approve);
                    $('#edit_reject').val(activity.reject);
                    $('#edit_status').val(activity.status);

                    // Uncheck all first
                    $('.edit-modules, .edit-notify').prop('checked', false);

                    // Check modules (ensure modules is an array)
                    let modules = activity.modules || [];
                    if (typeof modules === 'string') {
                        modules = JSON.parse(modules);
                    }
                    if (Array.isArray(modules)) {
                        modules.forEach(mod => {
                            $(`.edit-modules[value="${mod}"]`).prop('checked', true);
                        });
                    }

                    // Check notification types
                    let notifies = activity.notification_type || [];
                    if (typeof notifies === 'string') {
                        notifies = JSON.parse(notifies);
                    }
                    if (Array.isArray(notifies)) {
                        notifies.forEach(nt => {
                            $(`.edit-notify[value="${nt}"]`).prop('checked', true);
                        });
                    }

                    // Show modal after data is set
                    $('#EditTranModal').modal('show');
                },
                error: function() {
                    alert('Failed to fetch activity details. Please try again.');
                }
            });
        });


        // Handle AJAX form submission
        $('#editActivityForm').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Update response:', response);
                    $('#EditTranModal').modal('hide');
                    showPageAlert(response.message || 'Activity updated successfully!', 'success');

                    // Now fetch fresh data from DB for this activity ID
                  $.ajax({
                        url: '{{ route("activities.show", ":id") }}'.replace(':id', response.activity.id),
                        method: 'GET',
                        success: function(activity) {
                            // Find the row for this activity by data-id attribute
                            const row = $('#activitiesTableBody').find(`tr[data-id="${activity.id}"]`);
                            if (!row.length) return;

                            // Update all columns inline
                            row.find('td').eq(1).text(activity.name);     // Name
                            row.find('td').eq(2).text(activity.approve); // Approve
                            row.find('td').eq(3).text(activity.reject);  // Reject

                            // Helper to get icon html based on modules array
                            function getIcon(modName) {
                                return (activity.modules && activity.modules.includes(modName)) 
                                    ? '<i class="ri-checkbox-circle-line text-success"></i>' 
                                    : '<i class="ri-close-circle-line text-danger"></i>';
                            }

                            // Update module columns 4 to 8 (Workflow, Trigger, Notification, Report, Transaction)
                            row.find('td').eq(4).html(getIcon('Workflow'));
                            row.find('td').eq(5).html(getIcon('Trigger'));
                            row.find('td').eq(6).html(getIcon('Notification'));
                            row.find('td').eq(7).html(getIcon('Report'));
                            row.find('td').eq(8).html(getIcon('Transaction'));

                            // Update notification_type badges in column 9
                            if (activity.notification_type && Array.isArray(activity.notification_type)) {
                                let badges = '';
                                activity.notification_type.forEach(type => {
                                    badges += `<span class="badge bg-primary me-1">${type}</span>`;
                                });
                                row.find('td').eq(9).html(badges);
                            } else {
                                row.find('td').eq(9).html('');
                            }

                            // Update status in column 10
                            const statusBadge = activity.status === 'Active'
                                ? '<span class="badge bg-success-subtle text-success">Active</span>'
                                : '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

                            row.find('td').eq(10).html(statusBadge);
                            $('#activitiesTableBody tr').each(function(index) {
                                $(this).find('td').eq(0).text(index + 1);
                            });
                        },
                        error: function() {
                            console.warn('Failed to fetch fresh activity data');
                        }
                    });

                },

            });
        });
        $(document).on('click', '.delete-btn', function () {
            const activityId = $(this).data('id');
            const deleteUrl = '{{ route("activities.destroy", ":id") }}'.replace(':id', activityId);

            if (confirm('Are you sure you want to delete this activity?')) {
                $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            $(`#activitiesTableBody tr[data-id="${activityId}"]`).remove(); // Remove the row
                            showPageAlert(response.message, 'success');
                        } else {
                            showPageAlert(response.message || 'Failed to delete.', 'warning');
                        }
                    },
                    error: function () {
                        showPageAlert('An error occurred while deleting.', 'danger');
                    }
                });
            }
        });


    });
    $('#AddTranModal').on('show.bs.modal', function () {
        const modal = $(this);

        // Reset all input/select/textarea fields inside the modal
        modal.find('form')[0].reset();

        // Clear all checked checkboxes/radio buttons
        modal.find('input[type=checkbox], input[type=radio]').prop('checked', false);

        // Clear hidden inputs if needed
        modal.find('input[type=hidden]').val('');

        // Clear all validation error messages
        modal.find('.is-invalid').removeClass('is-invalid');
        modal.find('.invalid-feedback').remove(); // Assuming errors are shown this way

        // Optional: Clear custom alert/message areas if used
        modal.find('.alert, .error-msg, .text-danger').remove(); 
    });

</script>