<!-- CKEditor CDN in <head> or top of body -->
<script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header align-items-center d-flex p-2">
                <ol class="breadcrumb m-0 flex-grow-1">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Master Type</a></li>
                    <li class="breadcrumb-item active">Notification</li>
                </ol>
                <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2"
                    data-bs-toggle="modal" data-bs-target="#AddNotificationModal">
                    <i class="ri-add-line align-bottom me-1"></i> Add New
                </button>
                <div class="flex-shrink-0" style="font-size:16px;">
                    <a class="me-2" href=""><i class="las la-file-pdf"></i></a>
                    <a class="me-2" href=""><i class="las la-file-excel"></i></a>
                    <a class="me-2" href=""><i class="las la-file-csv"></i></a>
                </div>
            </div>

            <div class="card-body table-responsive">
                <div id="successMessage" class="alert alert-success d-none" role="alert"></div>

                <table id="companytable" class="table table-bordered table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>SR No.</th>
                            <th>Name</th>
                            <th>Notification Type</th>
                            <th>Messages</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="notificationtanlebody">
                        @foreach($notifications as $notification)
                        <tr data-id="{{ $notification->id }}">

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $notification->name }}</td>
                            <td>{{ $notification->notification_type }}</td>
                            <td>{{ $notification->message }}</td>
                            <td>
                                @if($notification->status == 'Active')
                                <span class="badge bg-success-subtle text-success">{{ $notification->status }}</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">{{ $notification->status }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-link text-primary edit-btn"
                                    data-id="{{ $notification->id }}"
                                    data-name="{{ $notification->name }}"
                                    data-message="{{$notification->message}}"
                                    data-notification_type="{{$notification->notification_type}}"
                                    data-status="{{ $notification->status }}"
                                    title="Edit">
                                    <i class="bx bx-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-link text-danger delete-btn" data-id="{{ $notification->id }}" title="Delete"><i class="bx bx-trash"></i></button>
                            </td>
                        </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Notification Modal -->
<div class="modal fade" id="AddNotificationModal" tabindex="-1" aria-labelledby="AddNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="AddNotificationModalLabel">Add New Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                <form id="notificationform">
                    <div id="errorMessage" class="alert alert-danger d-none" role="alert"></div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Notification Type</label>
                            <select class="form-select form-select-sm" id="notiType" name="noti">
                                <option value="Email">Email</option>
                                <option value="SMS">SMS</option>
                                <option value="InApp">In-App</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text" style="padding: 3px;" id="notiPrefix">Email</span>
                                <input type="text" class="form-control form-control-sm" id="notiNameInput" required>
                            </div>
                            <!-- Hidden input to hold combined value -->
                            <input type="hidden" name="name" id="hiddenName">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select form-select-sm" name="status">
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label mt-2">Message</label>
                            <textarea name="message" id="messageEditor" rows="6" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="notificationform" class="btn btn-sm btn-success">Submit</button>
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Notification Modal -->
<div class="modal fade" id="EditNotificationModal" tabindex="-1" aria-labelledby="EditNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="EditNotificationModalLabel">Edit Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                <form id="editNotificationForm">
                    <input type="hidden" name="id" id="edit_notification_id">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Notification Type</label>
                            <select class="form-select form-select-sm" id="edit_notiType" name="noti">
                                <option value="Email">Email</option>
                                <option value="SMS">SMS</option>
                                <option value="InApp">In-App</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <div class="input-group">
                                <span class="input-group-text" style="padding: 3px;" id="edit_notiPrefix">Email</span>
                                <input type="text" class="form-control form-control-sm" id="edit_notiNameInput" required>
                            </div>
                            <input type="hidden" name="name" id="edit_hiddenName">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_status">
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label mt-2">Message</label>
                            <textarea name="message" id="edit_messageEditor" rows="6" class="form-control form-control-sm"></textarea>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="editNotificationForm" class="btn btn-sm btn-success">Update</button>
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- CKEditor Modal Activation Script -->
<script>
    const modal = document.getElementById('AddNotificationModal');
    console.log(modal);

    modal.addEventListener('shown.bs.modal', function() {
        if (CKEDITOR.instances['messageEditor']) {
            CKEDITOR.instances['messageEditor'].destroy(true);
        }
        CKEDITOR.replace('messageEditor');
    });

    modal.addEventListener('hidden.bs.modal', function() {
        if (CKEDITOR.instances['messageEditor']) {
            CKEDITOR.instances['messageEditor'].destroy(true);
        }
    });

    // AJAX form submission
    $('#notificationform').on('submit', function(e) {
        e.preventDefault();

        // Update textarea with CKEditor data
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        var formData = $(this).serialize();

        $.ajax({
            url: "{{ route('notifications.store') }}",
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Clear previous errors
                $('#errorMessage').addClass('d-none').text('');

                // Show success message above the table
                $('#successMessage').removeClass('d-none').text('Notification added successfully.');

                // Hide modal
                $('#AddNotificationModal').modal('hide');

                // Append new row to the table
                let newRow = `
                <tr>
                    <td>${$('#companytable tbody tr').length + 1}</td>
                    <td>${response.name}</td>
                    <td>${response.notification_type}</td>
                    <td>${response.message}</td>
                    <td>
                    ${response.status === 'Active' 
                        ? '<span class="badge bg-success-subtle text-success">Active</span>' 
                        : '<span class="badge bg-danger-subtle text-danger">Deactive</span>'}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-link text-primary edit-btn"
                                            data-id="${response.id}"
                                            data-name="${response.name}"
                                            data-message="${response.message}"
                                            data-notification_type="${response.notification_type}"
                                            data-status=" ${response.status}"
                                            title="Edit">
                                        <i class="bx bx-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-link text-danger delete-btn" data-id="${response.id}" title="Delete"><i class="bx bx-trash"></i></button>
                    </td>
                    </tr>`;

                $('#companytable tbody').append(newRow);

                // Optional: Clear form
                $('#notificationform')[0].reset();
                CKEDITOR.instances['messageEditor'].setData('');
                $('#notiType').trigger('change');
            },
            error: function(xhr) {
                // Show error in modal
                let message = 'Something went wrong.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                $('#errorMessage').removeClass('d-none').text(message);
            }

        });
    });
    // Set prefix on dropdown change
    $('#notiType').on('change', function() {
        const type = $(this).val();
        $('#notiPrefix').text(type);

        // Optional: update full name if text input is already filled
        const nameInput = $('#notiNameInput').val();
        $('#hiddenName').val(type + '_' + nameInput);
    });

    // Update hidden input as user types
    $('#notiNameInput').on('input', function() {
        const type = $('#notiType').val();
        const nameVal = $(this).val();
        $('#hiddenName').val(type + '_' + nameVal);
    });

    // Initial setup (in case modal opens multiple times)
    $('#AddNotificationModal').on('shown.bs.modal', function() {
        $('#notiType').trigger('change');
    });

    let editMessageTemp = ''; // Temporarily store message before CKEditor loads

    // When Edit button is clicked
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const message = $(this).data('message');
        const type = $(this).data('notification_type');
        const status = $(this).data('status').trim();

        const nameOnly = name.replace(type + '_', '');

        // Set form values
        $('#edit_notification_id').val(id);
        $('#edit_notiType').val(type).trigger('change');
        $('#edit_notiNameInput').val(nameOnly).trigger('input');
        $('#edit_status').val(status);

        // Store message temporarily for use after CKEditor initializes
        editMessageTemp = message;

        // Show modal
        $('#EditNotificationModal').modal('show');
    });

    // Submit Edit Form via AJAX
    $('#editNotificationForm').on('submit', function (e) {
    e.preventDefault();

    // Sync CKEditor content
    for (const instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    const formData = $(this).serialize();
    const id = $('#edit_notification_id').val();
    let updateUrlTemplate = '{{ route("notifications.update", ":id") }}';
        let url = updateUrlTemplate.replace(':id', id);
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
        $('#EditNotificationModal').modal('hide');
        $('#edit_error').html('');

        // ✅ Show success
        $('#successMsg').html(`<div class="alert alert-success py-2 mb-2">Notification updated successfully.</div>`);

        // ✅ Optionally, update the table row (find by id or refresh table)
        $(`button.edit-btn[data-id="${response.id}"]`).closest('tr').html(`
            <td>${response.rownum}</td>
            <td>${response.name}</td>
            <td>${response.type}</td>
            <td>${response.message}</td>
            <td>
            ${response.status === 'Active' 
                ? '<span class="badge bg-success-subtle text-success">Active</span>' 
                : '<span class="badge bg-danger-subtle text-danger">Deactive</span>'}
            </td>
            <td>
            <button class="btn btn-sm btn-link text-primary edit-btn"
                data-id="${response.id}"
                data-name="${response.name}"
                data-message="${response.message}"
                data-notification_type="${response.type}"
                data-status="${response.status}">
                <i class="bx bx-pencil"></i>
            </button>
            </td>
        `);
        },
        error: function (xhr) {
        let errorMsg = 'An error occurred.';
        if (xhr.responseJSON?.message) {
            errorMsg = xhr.responseJSON.message;
        }
        $('#edit_error').html(`<div class="text-danger small">${errorMsg}</div>`);
        }
    });
    });

    // Update hidden name when type or input changes
    $('#edit_notiType').on('change', function () {
        const type = $(this).val();
        $('#edit_notiPrefix').text(type);
        const name = $('#edit_notiNameInput').val();
        $('#edit_hiddenName').val(type + '_' + name);
    });

    $('#edit_notiNameInput').on('input', function () {
        const type = $('#edit_notiType').val();
        $('#edit_hiddenName').val(type + '_' + $(this).val());
    });

    // Initialize CKEditor and load message AFTER modal is fully shown
    $('#EditNotificationModal').on('shown.bs.modal', function () {
        if (CKEDITOR.instances['edit_messageEditor']) {
            CKEDITOR.instances['edit_messageEditor'].destroy(true);
        }

        // Reinitialize
        CKEDITOR.replace('edit_messageEditor');

        // Set data after slight delay to ensure editor is ready
        setTimeout(() => {
            if (CKEDITOR.instances['edit_messageEditor']) {
                CKEDITOR.instances['edit_messageEditor'].setData(editMessageTemp);
            }
        }, 200);
    });

    // Clean up CKEditor instance when modal is hidden
    $('#EditNotificationModal').on('hidden.bs.modal', function () {
        if (CKEDITOR.instances['edit_messageEditor']) {
            CKEDITOR.instances['edit_messageEditor'].destroy(true);
        }
    });

    // Update hidden name on input or type change
    $('#edit_notiType').on('change', function() {
        const type = $(this).val();
        $('#edit_notiPrefix').text(type);
        const name = $('#edit_notiNameInput').val();
        $('#edit_hiddenName').val(type + '_' + name);
    });

    $('#edit_notiNameInput').on('input', function() {
        const type = $('#edit_notiType').val();
        $('#edit_hiddenName').val(type + '_' + $(this).val());
    });
</script>
<style>
    #successMessage {
        transition: all 0.5s ease;
    }
</style>