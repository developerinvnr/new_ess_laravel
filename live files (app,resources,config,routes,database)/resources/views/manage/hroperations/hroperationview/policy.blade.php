<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header align-items-center d-flex p-2">
                <ol class="breadcrumb m-0 flex-grow-1">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Type</a></li>
                    <li class="breadcrumb-item active">Policy</li>
                </ol>
                <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#AddPolicyModal"><i class="ri-add-line align-bottom me-1"></i> Add New</button>
                <div class="flex-shrink-0" style="font-size:16px;">
                    <a class="me-2" href=""><i class="las la-file-pdf"></i></a>
                    <a class="me-2" href=""><i class="las la-file-excel"></i></a>
                    <a class="me-2" href=""><i class="las la-file-csv"></i></a>
                </div>
            </div><!-- end card header -->

            <div class="card-body table-responsive">
                <table id="Policytable" class="table table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                    <thead>
                        <tr>

                            <th>SR No.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <div id="activityAlertContainerSuccess" class="mb-3">
                    <tbody id="PolicyTableBody">
                         @foreach($policies as $policy)
                        <tr data-id="{{ $policy->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $policy->policy_name }}</td>
                            <td>
                                @if($policy->status == 'Active')
                                <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">Deactive</span>
                                @endif
                            </td>

                            <td>
                                <a href="#"
                                    class="edit-policy-btn"
                                    data-id="{{ $policy->id }}"
                                    data-name="{{ $policy->policy_name }}"
                                    data-status="{{ $policy->status }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#EditPolicyModal">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-link text-danger delete-btn" data-id="{{ $policy->id }}" title="Delete"><i class="bx bx-trash"></i></button>


                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div>


<!-- ADD view Modal -->
<div class="modal fade" id="AddPolicyModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AddPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="AddPolicyModalLabel">Add New Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                <form id="activityForm">
                    <div id="modalAlertContainer" class="mb-3">
                        {{-- General error alerts will be inserted here --}}
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Policy Name</label>
                            <input type="text" class="form-control form-control-sm" name="name" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
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

<!-- Edit Modal -->
<div class="modal fade" id="EditPolicyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="EditPolicyModalLabel">Edit Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                <form id="editPolicyForm">
                    <input type="hidden" name="policy_id" id="edit_policy_id" />
                    <div id="editModalAlertContainer" class="mb-3"></div>

                    <div class="row g-3">
                        <!-- Event Name -->
                        <div class="col-md-12">
                            <label class="form-label">Policy Name</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="edit_policy_name" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_policy_status">
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="editPolicyForm" class="btn btn-sm btn-primary">Update</button>
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
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
    $('#AddPolicyModal').on('show.bs.modal', function() {
        const form = $('#activityForm')[0];
        form.reset();
    });


    $('#activityForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();

        $.ajax({
            url: '{{ route("policy.store") }}', // Adjust to your actual route
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#AddPolicyModal').modal('hide');
                showPageAlert(response.message || 'Policy added successfully!', 'success');

                // Append new row
                const serialNo = $('#PolicyTableBody tr').length + 1;
                const statusBadge = response.Policy.status === 'Active' ?
                    '<span class="badge bg-success-subtle text-success">Active</span>' :
                    '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

                const newRow = `
                <tr data-id="${response.Policy.id}">
                    <td>${serialNo}</td>
                    <td>${response.Policy.policy_name}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <a href="#" class="edit-policy-btn" 
                                    data-id="${response.Policy.id}" 
                                    data-name="${response.Policy.policy_name}" 
                                    data-status="${response.Policy.status}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#EditPolicyModal">
                                    <i class="bx bx-pencil"></i>
                                    </a>
                        <button class="btn btn-sm btn-link text-danger delete-btn" data-id="${response.Policy.id}" title="Delete"><i class="bx bx-trash"></i></button>
                    </td>
                </tr>
            `;
                $('#PolicyTableBody').append(newRow);
            },
            error: function(xhr) {
                showPageAlert('Something went wrong!', 'danger');
                showModalErrors(xhr.responseText);
            }
        });
    });

    $('#EditPolicyModal').on('show.bs.modal', function(policy) {
        const button = $(policy.relatedTarget); // The clicked edit icon
        const id = button.data('id');

        const fetchUrl = "{{ route('policy.show', ':id') }}".replace(':id', id);

        // Clear form and alert container first
        $('#editModalAlertContainer').empty();
        $('#editPolicyForm')[0].reset(); // optional reset before loading

        // Show loading or disable form if needed here

        // Fetch real-time data
        $.get(fetchUrl, function(response) {
            const policy = response.Policy;
            console.log(policy);

            $('#edit_policy_id').val(policy.id);
            $('#edit_policy_name').val(policy.policy_name);
            $('#edit_policy_status').val(policy.status);
        }).fail(function() {
            $('#editModalAlertContainer').html(`<div class="alert alert-danger">Unable to load policy data.</div>`);
        });
    });

    $('#editPolicyForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#edit_policy_id').val();
        const formData = $(this).serialize();
        const updateUrl = "{{ route('policy.update', ':id') }}".replace(':id', id);
        const fetchUrl = "{{ route('policy.show', ':id') }}".replace(':id', id);

        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: formData + '&_method=PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                $('#EditPolicyModal').modal('hide');
                showPageAlert('Policy updated successfully!', 'success');

                // 🔁 Now fetch the latest data from the server
                $.get(fetchUrl, function(response) {
                    const policy = response.Policy;

                    const statusBadge = policy.status === 'Active' ?
                        '<span class="badge bg-success-subtle text-success">Active</span>' :
                        '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

                    const row = $(`#PolicyTableBody tr[data-id="${policy.id}"]`);
                    row.find('td').eq(1).text(policy.policy_name);
                    row.find('td').eq(2).html(statusBadge);
                });
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors || null;
                if (errors) {
                    let errorMessages = Object.values(errors).flat().join('<br>');
                    $('#editModalAlertContainer').html(`<div class="alert alert-danger">${errorMessages}</div>`);
                } else {
                    $('#editModalAlertContainer').html(`<div class="alert alert-danger">Something went wrong!</div>`);
                }
                console.error(xhr.responseText);
            }
        });
    });
    $(document).on('click', '.delete-btn', function() {
        const policysId = $(this).data('id');
        const deleteUrl = '{{ route("policy.destroy", ":id") }}'.replace(':id', policysId);

        if (confirm('Are you sure you want to delete this activity?')) {
            $.ajax({
                url: deleteUrl,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response.success);
                    if (response.success) {
                        $(`#PolicyTableBody tr[data-id="${policysId}"]`).remove(); // Remove the row
                        showPageAlert(response.message, 'success');
                    } 
                    else if(response.success == 'false'){
                            // Show error message if success is false
                            if (response.errors) {
                                let messages = '';
                                for (const field in response.errors) {
                                    messages += `<div>${response.errors[field][0]}</div>`;
                                }
                                showPageAlert(messages, 'danger');
                            } else {
                                showPageAlert(response.message || 'Failed to delete.', 'warning');
                            }
                        }
                    else {
                            // Show error message if success is false
                            if (response.errors) {
                                let messages = '';
                                for (const field in response.errors) {
                                    messages += `<div>${response.errors[field][0]}</div>`;
                                }
                                showPageAlert(messages, 'danger');
                            } else {
                                showPageAlert(response.message || 'Failed to delete.', 'warning');
                            }
                        }

                },
                error: function(xhr) {
                    try {
                        const res = JSON.parse(xhr.responseText);

                        if (res.errors) {
                            let messages = '';
                            for (const field in res.errors) {
                                messages += `<div>${res.errors[field][0]}</div>`;
                            }

                            showPageAlert(messages, 'danger');
                        } else {
                            showPageAlert(res.message || 'Something went wrong!', 'danger');
                        }
                    } catch (e) {
                        showModalErrors('Unexpected error occurred!', 'danger');
                        showModalErrors('Parsing error response failed:', e, xhr.responseText);
                    }
                }

            });
        }
    });
</script>

<style>
    #Policytable th, 
    #Policytable td {
        text-align: center;
    }
</style>