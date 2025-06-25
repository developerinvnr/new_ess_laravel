<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header align-items-center d-flex p-2">
                <ol class="breadcrumb m-0 flex-grow-1">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Type</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
                <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#AddReportModal"><i class="ri-add-line align-bottom me-1"></i> Add New</button>
                <div class="flex-shrink-0" style="font-size:16px;">
                    <a class="me-2" href=""><i class="las la-file-pdf"></i></a>
                    <a class="me-2" href=""><i class="las la-file-excel"></i></a>
                    <a class="me-2" href=""><i class="las la-file-csv"></i></a>
                </div>
            </div><!-- end card header -->

            <div class="card-body table-responsive">
                <table id="Reporttable" class="table table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                    <thead>
                        <tr>

                            <th>SR No.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <div id="activityAlertContainerSuccess" class="mb-3">
                    <tbody id="ReporttableBody">
                         @foreach($reports as $report)
                        <tr data-id="{{ $report->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->report_name }}</td>
                            <td>
                                @if($report->status == 'Active')
                                <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger">Deactive</span>
                                @endif
                            </td>

                            <td>
                                <a href="#"
                                    class="edit-policy-btn"
                                    data-id="{{ $report->id }}"
                                    data-name="{{ $report->report_name }}"
                                    data-status="{{ $report->status }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#EditReportModal">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-link text-danger delete-btn" data-id="{{ $report->id }}" title="Delete"><i class="bx bx-trash"></i></button>


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
<div class="modal fade" id="AddReportModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="AddReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="AddReportModalLabel">Add New Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                <form id="activityForm">
                    <div id="modalAlertContainer" class="mb-3">
                        {{-- General error alerts will be inserted here --}}
                    </div>
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Report Name</label>
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
<div class="modal fade" id="EditReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="EditReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="EditReportModalLabel">Edit Policy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="font-family: roboto;">
                <form id="editReportForm">
                    <input type="hidden" name="report_id" id="edit_report_id" />
                    <div id="editModalAlertContainer" class="mb-3"></div>

                    <div class="row g-3">
                        <!-- Event Name -->
                        <div class="col-md-12">
                            <label class="form-label">Report Name</label>
                            <input type="text" class="form-control form-control-sm" name="name" id="edit_report_name" required>
                        </div>

                        <!-- Status -->
                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <select class="form-select form-select-sm" name="status" id="edit_report_status">
                                <option value="Active">Active</option>
                                <option value="Deactive">Deactive</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="submit" form="editReportForm" class="btn btn-sm btn-primary">Update</button>
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
    $('#AddReportModal').on('show.bs.modal', function() {
        const form = $('#activityForm')[0];
        form.reset();
    });


    $('#activityForm').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = form.serialize();

        $.ajax({
            url: '{{ route("report.store") }}', // Adjust to your actual route
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#AddReportModal').modal('hide');
                showPageAlert(response.message || 'Policy added successfully!', 'success');

                // Append new row
                const serialNo = $('#ReporttableBody tr').length + 1;
                const statusBadge = response.report.status === 'Active' ?
                    '<span class="badge bg-success-subtle text-success">Active</span>' :
                    '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

                const newRow = `
                <tr data-id="${response.report.id}">
                    <td>${serialNo}</td>
                    <td>${response.report.report_name}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <a href="#" class="edit-policy-btn" 
                                    data-id="${response.report.id}" 
                                    data-name="${response.report.report_name}" 
                                    data-status="${response.report.status}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#EditReportModal">
                                    <i class="bx bx-pencil"></i>
                                    </a>
                        <button class="btn btn-sm btn-link text-danger delete-btn" data-id="${response.report.id}" title="Delete"><i class="bx bx-trash"></i></button>
                    </td>
                </tr>
            `;
                $('#ReporttableBody').append(newRow);
            },
            error: function(xhr) {
                showPageAlert('Something went wrong!', 'danger');
                showModalErrors(xhr.responseText);
            }
        });
    });

    $('#EditReportModal').on('show.bs.modal', function(report) {
        const button = $(report.relatedTarget); // The clicked edit icon
        const id = button.data('id');

        const fetchUrl = "{{ route('report.show', ':id') }}".replace(':id', id);

        // Clear form and alert container first
        $('#editModalAlertContainer').empty();
        $('#editReportForm')[0].reset(); // optional reset before loading

        // Show loading or disable form if needed here

        // Fetch real-time data
        $.get(fetchUrl, function(response) {
            const report = response.report;

            $('#edit_report_id').val(report.id);
            $('#edit_report_name').val(report.report_name);
            $('#edit_report_status').val(report.status);
        }).fail(function() {
            $('#editModalAlertContainer').html(`<div class="alert alert-danger">Unable to load policy data.</div>`);
        });
    });

    $('#editReportForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#edit_report_id').val();
        const formData = $(this).serialize();
        const updateUrl = "{{ route('report.update', ':id') }}".replace(':id', id);
        const fetchUrl = "{{ route('report.show', ':id') }}".replace(':id', id);

        $.ajax({
            url: updateUrl,
            method: 'POST',
            data: formData + '&_method=PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                $('#EditReportModal').modal('hide');
                showPageAlert('Policy updated successfully!', 'success');

                // 🔁 Now fetch the latest data from the server
                $.get(fetchUrl, function(response) {
                    const report = response.report;

                    const statusBadge = report.status === 'Active' ?
                        '<span class="badge bg-success-subtle text-success">Active</span>' :
                        '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

                    const row = $(`#ReporttableBody tr[data-id="${report.id}"]`);
                    row.find('td').eq(1).text(report.report_name);
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
    const reportsId = $(this).data('id');
    const deleteUrl = '{{ route("report.destroy", ":id") }}'.replace(':id', reportsId);

    if (confirm('Are you sure you want to delete this activity?')) {
        $.ajax({
            url: deleteUrl,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Remove the deleted row
                    $(`#ReporttableBody tr[data-id="${reportsId}"]`).remove();

                    // Recalculate serial numbers for remaining rows
                    $('#ReporttableBody tr').each(function(index) {
                        $(this).find('td').eq(0).text(index + 1);
                    });

                    showPageAlert(response.message, 'success');
                } else {
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
                    console.error('Parsing error response failed:', e, xhr.responseText);
                }
            }
        });
    }
});


</script>

<style>
    #Reporttable th, 
    #Reporttable td {
        text-align: center;
    }
</style>