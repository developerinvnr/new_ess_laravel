
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Peepal Menus Master</h5>
    <div class="d-flex gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addListModal">
            <i class="ri-add-line align-bottom me-1"></i>Add List
        </button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuModal">
            <i class="ri-add-line align-bottom me-1"></i>Add Menu
        </button>
    </div>
</div>

<div id="successMessage" class="alert alert-success d-none"></div>

<table class="table table-bordered" id="menuTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Route</th>
            <th>Visible</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($menus as $menu)
        <tr id="menu-row-{{ $menu->id }}">
            <td>{{ $menu->name }}</td>
            <td>{{ $menu->route }}</td>
            <td>{{ $menu->is_visible ? 'Yes' : 'No' }}</td>
          <td>
            <button class="editMenuBtn" style="margin:5px;background:none; border:none; padding:0; color:#ffc107; cursor:pointer;"
                data-id="{{ $menu->id }}"
                data-name="{{ $menu->name }}"
                data-route="{{ $menu->route }}"
                data-visible="{{ $menu->is_visible }}">
                <i class="ri-edit-line align-bottom"></i>
            </button>
            <button class="deleteMenuBtn" style="background:none; border:none; padding:0; color:#dc3545; cursor:pointer;"
                data-id="{{ $menu->id }}">
                <i class="ri-delete-bin-line align-bottom"></i>
            </button>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-labelledby="addMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addMenuForm">
        @csrf

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="formErrorMsg" class="alert alert-danger d-none"></div> <!-- hidden by default -->

            <div class="modal-body">
                <div class="mb-3" id="menuListDropdown">
                    <label for="menu_list_id">Select Name</label>
                    <select name="name" id="name" class="form-select">
                        <option value="">-- Select List --</option>
                        @foreach($menuslist as $list)
                            <option value="{{ $list->name }}">{{ $list->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label>Route</label>
                    <input type="text" name="route" class="form-control">
                </div>
                <div class="form-check mb-3">
                    <input type="hidden" name="is_visible" value="0">
                    <input class="form-check-input" type="checkbox" name="is_visible" value="1" checked>
                    <label class="form-check-label">Visible</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Menu</button>
            </div>
        </div>
    </form>
  </div>
</div>

<!-- Edit Menu Modal -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editMenuForm">
        @csrf
        <input type="hidden" name="id" id="edit_menu_id">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="editFormErrorMsg" class="alert alert-danger d-none"></div>

            <div class="modal-body">
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Route</label>
                    <input type="text" name="route" class="form-control">
                </div>
                <div class="form-check mb-3">
                    <input type="hidden" name="is_visible" value="0">
                    <input class="form-check-input" type="checkbox" name="is_visible" value="1">
                    <label class="form-check-label">Visible</label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Menu</button>
            </div>
        </div>
    </form>
  </div>
</div>

<div class="modal fade" id="addListModal" tabindex="-1" aria-labelledby="addListModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addListModalLabel">Add List Name</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
                <div id="addListMsg" class="alert d-none" role="alert"></div>
        <div class="mb-3">
          <label for="listName" class="form-label">List Name</label>
          <input type="text" class="form-control" name="name" id="listName" required>
          <div id="name-error" class="text-danger mt-1" style="display: none;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveListBtn" class="btn btn-primary">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
        const modalEl = document.getElementById('addMenuModal');
        const modal = new bootstrap.Modal(modalEl);

        modalEl.addEventListener('show.bs.modal', function () {
            $('#addMenuForm')[0].reset();
            $('#formErrorMsg').addClass('d-none').text('');
            $('#menu_id').val('');
            $('#addMenuModal .modal-title').text('Add Menu');
        });

        // Handle Edit
        $(document).on('click', '.editMenuBtn', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const route = $(this).data('route');
            const visible = $(this).data('visible');

            const form = $('#editMenuForm');

            form.find('#edit_menu_id').val(id);
            form.find('[name="name"]').val(name);
            form.find('[name="route"]').val(route);
            form.find('[name="is_visible"]').prop('checked', visible == 1);
            $('#editFormErrorMsg').addClass('d-none').text('');

            bootstrap.Modal.getOrCreateInstance(document.getElementById('editMenuModal')).show();
        });

        $('#saveListBtn').on('click', function () {
            let listName = $('#listName').val();
            let $errorDiv = $('#name-error');
            let $msgDiv = $('#addListMsg');

            // Clear old messages
            $errorDiv.hide().text('');
            $msgDiv.removeClass('alert-success alert-danger').addClass('d-none').text('');

            $.ajax({
                url: "{{ route('menu-names.store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    name: listName
                },
                success: function (response) {
                    $('#listName').val('');

                    $msgDiv.removeClass('d-none alert-danger').addClass('alert-success').text('List added successfully!');

                    // Optional: Close the modal after 1.5 sec
                    setTimeout(() => {
                        $('#addListModal').modal('hide');
                        $msgDiv.addClass('d-none').text('');
                    }, 1500);

                    // Optional: Append to dropdown or list
                    // $('#yourDropdown').append(new Option(response.name, response.id));
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $errorDiv.text(errors.name[0]).show();
                        }
                    } else {
                        $msgDiv.removeClass('d-none alert-success').addClass('alert-danger').text('An error occurred while saving.');
                    }
                }
            });
        });


        // Handle Save (Add or Update)
        $('#addMenuForm').submit(function (e) {
            e.preventDefault();
            const id = $('#menu_id').val();
            const formData = $(this).serialize();

            const url = id
                ? "{{ url('menumasteremployee/update') }}"  // your update route
                : "{{ route('menumasteremployee.store') }}"; // your existing store route

            const method = id ? 'POST' : 'POST'; // both POST, but route will differ

            $.ajax({
                url: url,
                method: method,
                data: formData,
                success: function (res) {
                    const row = `<tr id="menu-row-${res.id}">
                        <td>${res.name}</td>
                        <td>${res.route ?? ''}</td>
                        <td>${res.is_visible == 1 ? 'Yes' : 'No'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning editMenuBtn"
                                style="margin:5px;background:none; border:none; padding:0; color:#ffc107; cursor:pointer;"
                                data-id="${res.id}"
                                data-name="${res.name}"
                                data-route="${res.route}"
                                data-visible="${res.is_visible}">
                                <i class="ri-edit-line align-bottom"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteMenuBtn"
                            style="background:none; border:none; padding:0; color:#dc3545; cursor:pointer;"
                                data-id="${res.id}">
                                <i class="ri-delete-bin-line align-bottom"></i>
                            </button>
                        </td>
                    </tr>`;

                    if (id) {
                        $(`#menu-row-${res.id}`).replaceWith(row);
                    } else {
                        $('#menuTable tbody').append(row);
                    }

                    modal.hide();
                    $('#addMenuForm')[0].reset();
                    showSuccessMessage('Menu added successfully!');

                },
                error: function (err) {
                    let $errorDiv = $('#formErrorMsg');
                    if (err.status === 409 && err.responseJSON?.message) {
                        $errorDiv.text(err.responseJSON.message).removeClass('d-none');
                    } else {
                        $errorDiv.text('Error saving menu.').removeClass('d-none');
                    }
                }
            });
        });
        $('#editMenuForm').submit(function (e) {
            e.preventDefault();
            const id = $('#edit_menu_id').val();
            const formData = $(this).serialize();

            $.ajax({
                url: "{{ route('menumasteremployee/update') }}",
                method: 'POST',
                data: formData,
                success: function (res) {
                    console.log(res);
                    const row = `<tr id="menu-row-${res.id}">
                        <td>${res.name}</td>
                        <td>${res.route ?? ''}</td>
                        <td>${res.is_visible == 1 ? 'Yes' : 'No'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning editMenuBtn"
                            style="margin:5px;background:none; border:none; padding:0; color:#ffc107; cursor:pointer;"
                                data-id="${res.id}"
                                data-name="${res.name}"
                                data-route="${res.route}"
                                data-visible="${res.is_visible}">
                                <i class="ri-edit-line align-bottom"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteMenuBtn"
                            style="background:none; border:none; padding:0; color:#dc3545; cursor:pointer;"
                                data-id="${res.id}">
                                <i class="ri-delete-bin-line align-bottom"></i>
                            </button>
                        </td>
                    </tr>`;

                    $(`#menu-row-${res.id}`).replaceWith(row);

                    bootstrap.Modal.getOrCreateInstance(document.getElementById('editMenuModal')).hide();
                    $('#editMenuForm')[0].reset();
                    showSuccessMessage('Menu updated successfully!');

                },
                error: function (err) {
                    let $errorDiv = $('#editFormErrorMsg');
                    if (err.status === 409 && err.responseJSON?.message) {
                        $errorDiv.text(err.responseJSON.message).removeClass('d-none');
                    } else {
                        $errorDiv.text('Error updating menu.').removeClass('d-none');
                    }
                }
            });
        });


        // Handle Delete
        $(document).on('click', '.deleteMenuBtn', function () {
            const id = $(this).data('id');

            if (!confirm('Are you sure you want to delete this menu?')) return;

            $.ajax({
                url: "{{ route('menumasteremployee/delete') }}",
                method: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    $(`#menu-row-${id}`).remove();
                    showSuccessMessage('Menu deleted successfully!');

                },
                error: function () {
                    alert('Error deleting menu.');
                }
            });
        });
    });
 
// Utility function to show the success message
function showSuccessMessage(message) {
    $('#successMessage')
        .text(message)
        .removeClass('d-none')
        .hide()
        .fadeIn();

    setTimeout(() => {
        $('#successMessage').fadeOut();
    }, 4000);
}

</script>
