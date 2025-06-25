<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <div class="card-header border-0">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#AddNewRoleModal">
                                    <i class="ri-add-line align-bottom me-1"></i> Add Role
                                </button>
                               <a class="btn btn-primary" href="javascript:void(0);" onclick="togglePermissionTable()">
                                    Permission List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body" id="role-table">
                    <div class="table-data">
                        <table class="table table-bordered table-striped" id="data-table">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr style="vertical-align: middle;">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $role->name }}</td>
                                        <td style="white-space: normal; width: 60%;">
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge bg-danger-subtle text-danger">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            {{ $role->status === 'active' ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('roles.edit', $role->id) }}"
                                                class="btn btn-soft-info btn-sm edit-role"
                                                data-id="{{ $role->id }}">
                                                <i class="bx bx-pencil"></i>
                                            </a>

                                        <button class="btn btn-soft-danger btn-sm"
                                                onclick="deleteData(this)"
                                                data-url="{{ route('roles.destroy', $role->id) }}">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                           
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No roles available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body" id="permission-table" style="display: none;">
                    <div class="col-lg-12" id="divLanding">
                        @foreach ($permissions as $module => $groups)
                            <div class="card mb-4">
                                <div class="card-header" style="background-color: #a5cccd;">
                                    <h5 class="mb-0">{{ $module }}</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($groups as $group => $permissionList)
                                        @foreach ($permissionList as $permission)
                                            <span class="badge bg-danger-subtle text-danger me-1 mb-1">
                                                {{ $permission['name'] }}
                                            </span>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>



                </div>



            </div>
        </div>
    </div>
</div>

<!-- Modal for add new role  -->
<div class="modal fade" id="AddNewRoleModal" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div id="formErrors" class="alert alert-danger alert-dismissible fade d-none mx-3 mt-3" role="alert" style="width:297px;height: 47px;">
                <button type="button" class="btn-close" aria-label="Close" onclick="$('#formErrors').addClass('d-none').removeClass('show fade');"></button>
                <div id="formErrorsContent"></div>
                </div>
                <div class="modal-header">
                    <h5 class="modal-title">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form method="POST" id="addRoleForm">
                    @csrf
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                        <div class="row mb-3">
                            <!-- Role Name -->
                            <div class="col-md-4">
                                <label for="role_name">Role Name :</label> <span class="text-danger">*</span>
                                <input type="text" name="role_name" id="role_name" class="form-control">
                                <span class="text-danger error-text role_name_error"></span>
                            </div>
                        </div>
                
                        <!-- Permissions Accordion -->
                        <div class="accordion" id="permissionsAccordion">
                            @foreach($permissions as $module => $groups)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $module }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $module }}" aria-expanded="true" aria-controls="collapse-{{ $module }}">
                                        {{ strtoupper($module) }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $module }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $module }}" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        @foreach($groups as $group => $permissions)
                                        <div class="mb-3">
                                            <!-- Group Header -->
                                            <div class="d-flex align-items-center">
                                                <input type="checkbox" class="form-check-input me-2" onclick="checkAllPermissions('{{Str::slug($group)}}');" />
                                                <h6 class="mb-0 text-primary">{{ strtoupper($group) }}</h6>
                                            </div>
                
                                            <!-- Group Permissions -->
                                            <div class="row mt-2">
                                                @foreach($permissions as $permission)
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="permission[]" class="form-check-input {{Str::slug($group)}}" id="{{$permission['id']}}" value="{{$permission['name']}}">
                                                        <label class="form-check-label" for="{{$permission['id']}}">{{ $permission['name'] }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <hr>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
                

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editRoleForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="editRoleModalBody">
          <!-- Content will be loaded here dynamically -->
          <div class="text-center">Loading...</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>


<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editRoleForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="role_id" id="editRoleId">
          
          <div class="mb-3">
            <label for="editRoleName" class="form-label">Role Name</label>
            <input type="text" name="name" id="editRoleName" class="form-control" required>
          </div>

          <div class="mb-3" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
            <label class="form-label">Permissions</label>
            <div id="editRolePermissions">
              <!-- Permissions checkboxes will be inserted here -->
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>



<script>
$(document).ready(function () {
    $('#addRoleForm').on('submit', function (e) {
        e.preventDefault(); // prevent default form submission

        var form = $(this);
        var formData = form.serialize(); // serialize form data

        $.ajax({
            url: "{{ route('roles.store') }}",
            type: "POST",
            data: formData,
          success: function (response) {
             console.log(response);
                if (response.success) {
                    toastr.success("Role created successfully!");
                    $('#AddNewRoleModal').modal('hide');
                    location.reload(); // Optional
                } else {
                    toastr.error("Something went wrong.");
                }
            },

          error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorHtml = '';

                $.each(errors, function(key, value) {
                    errorHtml += '<p>' + value[0] + '</p>';
                });

                $('#formErrorsContent').html(errorHtml);
                $('#formErrors').removeClass('d-none').addClass('show fade');
            }


        });
    });
});
function checkAllPermissions(groupClass) {
    const groupCheckbox = event.target;
    const checkboxes = document.querySelectorAll('.' + groupClass);

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = groupCheckbox.checked;
    });
}
function editCheckAllPermissions(group) {
    const checkboxes = document.querySelectorAll(`#EditRoleModal .${group}`);
    const masterCheckbox = event.target;
    checkboxes.forEach((checkbox) => {
        checkbox.checked = masterCheckbox.checked;
    });
}

document.querySelectorAll('.edit-role').forEach(btn => {
  btn.addEventListener('click', function(e) {
    e.preventDefault();

    const roleId = this.dataset.id;
    const url = `/manage/roles/${roleId}/edit`; // Your edit route URL

    const modalBody = document.getElementById('editRoleModalBody');
    const form = document.getElementById('editRoleForm');

    // Show modal
    var modal = new bootstrap.Modal(document.getElementById('editRoleModal'));
    modal.show();

    // Show loading text
    modalBody.innerHTML = `<div class="text-center">Loading...</div>`;

    // Load the edit form from server via AJAX (fetch)
    fetch(url)
      .then(response => response.text())
      .then(html => {
        modalBody.innerHTML = html;

        // Set form action for update
        form.action = `/manage/roles/${roleId}`;
      })
      .catch(() => {
        modalBody.innerHTML = `<div class="text-danger text-center">Failed to load form.</div>`;
      });
  });
});
document.addEventListener('click', function (e) {
  if (e.target.matches('.edit-role')) {
    e.preventDefault();

    const roleId = e.target.dataset.id;
    const url = `/manage/roles/${roleId}/edit`;

    const modalElement = document.getElementById('editRoleModal');
    const modalBody = document.getElementById('editRoleModalBody');

    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    modalBody.innerHTML = `<div class="text-center py-3">Loading...</div>`;

    // Load form content into modal
    fetch(url)
      .then(response => response.text())
      .then(html => {
        modalBody.innerHTML = html;

        attachFormSubmitHandler(roleId); // attach the handler after form is injected
      })
      .catch(() => {
        modalBody.innerHTML = `<div class="text-danger text-center">Failed to load form.</div>`;
      });
  }
});

function attachFormSubmitHandler(roleId) {
  const form = document.getElementById('editRoleForm');
  if (!form) return;

  // Remove any previous submit handler to avoid duplicates
  form.removeEventListener('submit', form._submitHandler);

  // Create the handler function
  const submitHandler = function (e) {
    e.preventDefault();

    const formData = new FormData(form);
    const url = form.action;

    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        const reloadUrl = `/manage/roles/${roleId}/edit`;

        fetch(reloadUrl)
          .then(response => response.text())
          .then(html => {
            document.getElementById('editRoleModalBody').innerHTML = `
              <div class="alert alert-success text-center">${data.message}</div>
              ${html}
            `;

            attachFormSubmitHandler(roleId); // Reattach handler for new form
          });
      })
      .catch(error => {
        console.error('Error submitting form:', error);
        document.getElementById('editRoleModalBody').innerHTML = `
          <div class="alert alert-danger text-center">Error submitting form.</div>
        `;
      });
  };

  // Attach the handler and save reference to remove later
  form.addEventListener('submit', submitHandler);
  form._submitHandler = submitHandler;
}
function deleteData(button) {
  if (!confirm('Are you sure you want to delete this role?')) return;

  const url = button.dataset.url;

  fetch(url, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
      'X-Requested-With': 'XMLHttpRequest',
      'Accept': 'application/json',
    }
  })
  .then(response => response.json())
  .then(data => {
  if (data.success) {
    toastr.success(data.message); // Show success toaster
    // Remove row or reload after a short delay for better UX
    setTimeout(() => location.reload(), 1500);
  } else {
    toastr.error(data.message || 'Failed to delete role.'); // Show error toaster
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error('An unexpected error occurred.'); // Show error toaster
        });
}
function togglePermissionTable() {
    const permissionSection = document.getElementById('permission-table');
    const roleSection = document.getElementById('role-table');

    const isPermissionVisible = permissionSection.style.display === 'block' || permissionSection.style.display === '';

    // Toggle visibility
    permissionSection.style.display = isPermissionVisible ? 'none' : 'block';
    roleSection.style.display = isPermissionVisible ? 'block' : 'none';
}

</script>

