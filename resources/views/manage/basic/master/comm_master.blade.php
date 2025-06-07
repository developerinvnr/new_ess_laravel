<div class="m-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Communication Control</h5>
     
        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addModuleModal">
            <i class="ri-add-line"></i> Add Module
        </button>
    </div>
<div id="successMessage" class="alert alert-success d-none"></div>
<div id="ErrorMessage" class="alert alert-danger d-none"></div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Module Name</th>
                <th>Status</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($communicationModules as $module)
               <tr id="menu-row-comm-{{ $module->id }}">
                    <td class="module-name">{{ $module->module_name }}</td>
                    <td>
                        <div class="form-check form-switch">
                            <input 
                                class="form-check-input toggle-status" 
                                type="checkbox" 
                                data-id="{{ $module->id }}" 
                                {{ $module->status == 1 ? 'checked' : '' }} disabled>
                            <label class="form-check-label">
                                {{ $module->status ? 'Active' : 'Inactive' }}
                            </label>
                        </div>
                    </td>
                    <td>
                    <button class="btn btn-sm btn-link text-primary editModuleBtn" data-id="{{ $module->id }}">
                        <i class="ri-pencil-line"></i>
                    </button>
                    <button class="btn btn-sm btn-link text-success saveModuleBtn d-none" data-id="{{ $module->id }}">
                        <i class="ri-save-line"></i>
                    </button>
                    <button class="deleteMenuBtn" style="background:none; border:none; padding:0; color:#dc3545; cursor:pointer;"
                        data-id="{{ $module->id }}">
                        <i class="ri-delete-bin-line align-bottom"></i>
                    </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Module Modal -->
<div class="modal fade" id="addModuleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addModuleForm" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModuleModalLabel">Add Communication Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                    <div id="errorMessage" class="alert alert-danger d-none mt-2"></div>

                    <div class="mb-3">
                        <label for="module_name" class="form-label">Module Name</label>
                        <input type="text" name="module_name" id="module_name" class="form-control" required>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="statusSwitch" checked>
                        <label class="form-check-label" for="statusSwitch">Active</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save Module</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#addModuleForm').on('submit', function(e) {
        e.preventDefault();

        // Hide previous messages
        $('#successMessage').addClass('d-none').text('');
        $('#errorMessage').addClass('d-none').text('');
             
        let formData = {
            _token: '{{ csrf_token() }}',
            module_name: $('#module_name').val(),
            status: $('#statusSwitch').is(':checked') ? 1 : 0,
        };

        $.ajax({
            url: '{{ route("communication.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Close modal
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addModuleModal')).hide();

                    // Show success message above the table
                    $('#successMessage').removeClass('d-none').text(response.message);
                    setTimeout(function() {
                        $('#successMessage').addClass('d-none').text('');
                    }, 4000);

                    // Reset form
                    $('#addModuleForm')[0].reset();

                    // Ensure status switch is checked (default)
                    $('#statusSwitch').prop('checked', true);

                    // Hide any messages
                    $('#errorMessage').addClass('d-none').text('');
         
                    // Append new row to table
                    let newRow = `
                        <tr id="menu-row-comm-${response.id}">
                            <td>${formData.module_name}</td>
                            <td>
                               

                                    <div class="form-check form-switch">
                                        <input 
                                            class="form-check-input toggle-status" 
                                            type="checkbox" 
                                            data-id="${response.id}" 
                                            ${formData.status == 1 ? 'checked' : ''} disabled>
                                        <label class="form-check-label">
                                            ${formData.status == 1 ? 'Active' : 'Inactive'}
                                        </label>
                                    </div>
                                
                            </td>
                            <td>   
                             <button class="btn btn-sm btn-link text-primary editModuleBtn" data-id="${response.id }">
                                <i class="ri-pencil-line"></i>
                            </button>
                            <button class="btn btn-sm btn-link text-success saveModuleBtn d-none" data-id="${response.id }">
                                <i class="ri-save-line"></i>
                            </button>
                               <button class="deleteMenuBtn" style="background:none; border:none; padding:0; color:#dc3545; cursor:pointer;"
                                        data-id="${response.id }">
                                        <i class="ri-delete-bin-line align-bottom"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    $('table tbody').append(newRow);
                }
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.message || 'An error occurred. Please try again.';
                $('#errorMessage').removeClass('d-none').text(errorMsg);
                
            }
        });
    });
    $(document).on('click', '.editModuleBtn', function () {
    const id = $(this).data('id');
    const row = $(`#menu-row-comm-${id}`);
    
    // Convert module name to input
    const moduleName = row.find('.module-name').text().trim();
    row.find('.module-name').html(`<input type="text" class="form-control form-control-sm edit-name-input" value="${moduleName}">`);

    // Enable checkbox
    row.find('.toggle-status').prop('disabled', false);

    // Toggle buttons
    row.find('.editModuleBtn').addClass('d-none');
    row.find('.saveModuleBtn').removeClass('d-none');
});

$(document).on('click', '.saveModuleBtn', function () {
    const id = $(this).data('id');
    const row = $(`#menu-row-comm-${id}`);
    const updatedName = row.find('.edit-name-input').val();
    const updatedStatus = row.find('.toggle-status').is(':checked') ? 1 : 0;

    $.ajax({
        url: '{{ route("communication.update") }}', // Create this route in web.php/controller
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            module_name: updatedName,
            status: updatedStatus
        },
        success: function (response) {
            // Replace input with updated name
            row.find('.module-name').text(updatedName);

            // Disable checkbox again
            row.find('.toggle-status').prop('disabled', true);

            // Update status label
            const label = row.find('label.form-check-label');
            label.text(updatedStatus ? 'Active' : 'Inactive');

            // Toggle buttons back
            row.find('.saveModuleBtn').addClass('d-none');
            row.find('.editModuleBtn').removeClass('d-none');
            $('#successMessage').removeClass('d-none').text(response.message);
                    setTimeout(function() {
                        $('#successMessage').addClass('d-none').text('');
                    }, 4000);
        },
        error: function (xhr) {
            alert(xhr.responseJSON?.message || 'Failed to update module.');
        }
    });
});


    $(document).ready(function () {

        const modalEl = document.getElementById('addModuleModal');
            const modal = new bootstrap.Modal(modalEl);

            modalEl.addEventListener('show.bs.modal', function () {
                $('#addModuleForm')[0].reset();
                $('#errorMessage').addClass('d-none').text('');
                $('#module_name').val('');
                $('#addModuleModal .modal-title').text('Add Communication Module');
            });
    });
    // Handle Delete
        $(document).on('click', '.deleteMenuBtn', function () {
            const id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this menu?')) return;

            $.ajax({
                url: "{{ route('communicationmaster/delete') }}",
                method: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    $(`#menu-row-comm-${id}`).remove();
                     $('#ErrorMessage').removeClass('d-none').text('Communication Module deleted successfully!');
                    setTimeout(function() {
                        $('#ErrorMessage').addClass('d-none').text('');
                    }, 4000);

                },
                error: function () {
                    alert('Error deleting Communication Module.');
                }
            });
        });


</script>


