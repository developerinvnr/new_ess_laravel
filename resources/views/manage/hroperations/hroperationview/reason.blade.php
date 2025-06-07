<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header align-items-center d-flex p-2">
                <ol class="breadcrumb m-0 flex-grow-1">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Type</a></li>
                    <li class="breadcrumb-item active">Reason</li>
                </ol>
                <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#AddReasonModal"><i class="ri-add-line align-bottom me-1"></i> Add New</button>
                <div class="flex-shrink-0" style="font-size:16px;">
                    <a class="me-2" href=""><i class="las la-file-pdf"></i></a>
                    <a class="me-2" href=""><i class="las la-file-excel"></i></a>
                    <a class="me-2" href=""><i class="las la-file-csv"></i></a>
                </div>
            </div><!-- end card header -->

            <div class="card-body table-responsive">
                <table id="companytable" class="table table-bordered dt-responsive nowrap table-striped align-middle equal-header" style="width:100%">
                    <thead>
                        <tr>

                            <th>SR No.</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="reasonsTableBody">
                        @foreach($reasons as $key => $reason)
                        <tr data-id="{{ $reason->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reason->name }}</td>
                            <td>
                                @if($reason->status == 'Active')
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Deactive</span>
                                @endif
                            </td>
                               <td>
                                    <button class="btn btn-sm btn-link text-primary edit-btn"
                                            data-id="{{ $reason->id }}"
                                            data-name="{{ $reason->name }}"
                                            data-status="{{ $reason->status }}"
                                            title="Edit">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                <button class="btn btn-sm btn-link text-danger delete-btn" data-id="{{ $reason->id }}" title="Delete"><i class="bx bx-trash"></i></button>
                            </td>                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div>

<!-- Add view Modal -->
<div class="modal fade" id="AddReasonModal" tabindex="-1" aria-labelledby="AddReasonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="AddReasonModalLabel">Add New Reason</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="font-family: roboto;">
        <form id="reasonForm">
          <div class="row g-3">
            <!-- Event Name -->
            <div class="col-md-12">
              <label class="form-label">Reason Name</label>
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
        <button type="submit" form="reasonForm" class="btn btn-sm btn-success">Submit</button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Reason Modal -->
<div class="modal fade" id="EditReasonModal" tabindex="-1" aria-labelledby="EditReasonModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="EditReasonModalLabel">Edit Reason</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="font-family: roboto;">
        <form id="editReasonForm">
          <input type="hidden" name="id" id="edit_reason_id">
          <div class="row g-3">
            <div class="col-md-12">
              <label class="form-label">Reason Name</label>
              <input type="text" class="form-control form-control-sm" name="name" id="edit_reason_name" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Status</label>
              <select class="form-select form-select-sm" name="status" id="edit_reason_status">
                <option value="Active">Active</option>
                <option value="Deactive">Deactive</option>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="submit" form="editReasonForm" class="btn btn-sm btn-success">Update</button>
        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$('#AddReasonModal').on('show.bs.modal', function () {
    $('#reasonForm')[0].reset();
});

$('#reasonForm').on('submit', function (e) {
    e.preventDefault();
    const formData = $(this).serialize();

    $.ajax({
        url: "{{ route('reasons.store') }}",
        method: "POST",
        data: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            $('#AddReasonModal').modal('hide');

            const serialNo = $('#companytable tbody tr').length + 1;
            const badgeClass = response.reason.status === 'Active'
                ? '<span class="badge bg-success-subtle text-success">Active</span>'
                : '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

            const newRow = `
                <tr data-id="${response.reason.id}">
                    <td>${serialNo}</td>
                    <td>${response.reason.name}</td>
                    <td>${badgeClass}</td>
                    <td>
                                    <button class="btn btn-sm btn-link text-primary edit-btn"
                                            data-id="${response.reason.id}"
                                            data-name="${response.reason.name}"
                                            data-status="${response.reason.status}"
                                            title="Edit">
                                        <i class="bx bx-pencil"></i>
                                    </button>
                                <button class="btn btn-sm btn-link text-danger delete-btn" data-id="${response.reason.id}" title="Delete"><i class="bx bx-trash"></i></button>
                    </td> 
                </tr>
            `;
            $('#companytable tbody').append(newRow);
        },
        error: function(xhr) {
            alert("Something went wrong.");
            console.log(xhr.responseText);
        }
    });
});
$(document).on('click', '.edit-btn', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');
    const status = $(this).data('status');

    $('#edit_reason_id').val(id);
    $('#edit_reason_name').val(name);
    $('#edit_reason_status').val(status);

    $('#EditReasonModal').modal('show');
});

$('#editReasonForm').on('submit', function (e) {
    e.preventDefault();

    const id = $('#edit_reason_id').val();
    const formData = $(this).serialize();

    const url = "{{ route('reasons.update', ':id') }}".replace(':id', id);

    $.ajax({
        url: url,
        method: 'PUT',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
            $('#EditReasonModal').modal('hide');

            const badge = response.reason.status === 'Active'
                ? '<span class="badge bg-success-subtle text-success">Active</span>'
                : '<span class="badge bg-danger-subtle text-danger">Deactive</span>';

            const row = $(`tr[data-id="${response.reason.id}"]`);
            row.find('td').eq(1).text(response.reason.name);
            row.find('td').eq(2).html(badge);

            // Also update data attributes on edit button
            row.find('.edit-btn')
                .data('name', response.reason.name)
                .data('status', response.reason.status);
        },
        error: function (xhr) {
            alert('Update failed!');
            console.error(xhr.responseText);
        }
    });
});
 $(document).on('click', '.delete-btn', function () {
            const reasonsId = $(this).data('id');
            const deleteUrl = '{{ route("reasons.destroy", ":id") }}'.replace(':id', reasonsId);

            if (confirm('Are you sure you want to delete this activity?')) {
                $.ajax({
                    url: deleteUrl,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            $(`#reasonsTableBody tr[data-id="${reasonsId}"]`).remove(); // Remove the row
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


</script>
