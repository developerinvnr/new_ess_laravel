@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Manage Permissions for {{ $user->Fname }} {{ $user->Sname }} {{ $user->Lname }} ({{ $user->EmpCode }})</h3>

    <div id="permission-response" style="display: none;" class="alert"></div>

    <div class="mb-4">
        <h5>User Role-wise Permissions</h5>

        @php
            $roles = $user->roles;
            $userDirectPermissions = $user->getDirectPermissions()->pluck('name')->toArray();
        @endphp

        @if($roles->count())
            @foreach($roles as $role)
                <div class="card mb-3">
                    <div class="card-header bg-primary text-black">
                        <strong>{{ $role->name }}</strong>
                    </div>
                    <div class="card-body">
                        @php
                            $rolePermissions = $role->permissions;
                        @endphp

                        @if($rolePermissions->count())
                            <div class="row">
                                @foreach($rolePermissions as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input 
                                                type="checkbox" 
                                                class="form-check-input permission-checkbox" 
                                                data-permission="{{ $permission->name }}"
                                                id="perm_{{ $permission->id }}"
                                                {{ in_array($permission->name, $userDirectPermissions) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No permissions in this role.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p>No roles assigned to this user.</p>
        @endif
    </div>
</div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.permission-checkbox').on('change', function () {
        let allPermissions = [];

        $('.permission-checkbox').each(function () {
            allPermissions.push({
                permission: $(this).data('permission'),
                checked: $(this).is(':checked') ? 1 : 0
            });
        });

        console.log('Collected permissions array:', allPermissions); // Debug: show array before flattening

        // Convert to a flat key-value object so Laravel parses array properly
        let dataToSend = { _token: '{{ csrf_token() }}' };
        allPermissions.forEach((perm, index) => {
            dataToSend[`permissions[${index}][permission]`] = perm.permission;
            dataToSend[`permissions[${index}][checked]`] = perm.checked;
        });

        console.log('Data to send in AJAX:', dataToSend); // Debug: show flattened object

        let url = "{{ route('user.permission.update', $user->EmployeeID) }}";

        $.ajax({
            url: url,
            method: 'POST',
            data: dataToSend,
            success: function (response) {
                console.log('AJAX success response:', response); // Debug: show server response

                $('#permission-response')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(response.message || 'Permissions updated.')
                    .fadeIn().delay(1500).fadeOut();
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error, xhr.responseText); // Debug: show error details

                $('#permission-response')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text('Failed to update permissions.')
                    .fadeIn().delay(1500).fadeOut();
            }
        });
    });
});
</script>


