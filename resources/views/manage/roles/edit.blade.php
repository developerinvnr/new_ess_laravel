@csrf
@method('PUT')

<div class="row mb-3">
    <!-- Role Name -->
    <div class="col-md-4">
        <label for="role_name">Role Name :</label> <span class="text-danger">*</span>
        <input type="text" name="role_name" id="role_name" value="{{ $role->name }}" class="form-control" required>
        <span class="text-danger error-text role_name_error"></span>
    </div>
</div>

<!-- Permissions Accordion -->
<div class="accordion" id="permissionsAccordion" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
       @foreach($permissions as $module => $groups)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading-{{ Str::slug($module) }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ Str::slug($module) }}" aria-expanded="true" aria-controls="collapse-{{ Str::slug($module) }}">
                    {{ strtoupper($module) }}
                </button>
            </h2>
            <div id="collapse-{{ Str::slug($module) }}" class="accordion-collapse collapse show" aria-labelledby="heading-{{ Str::slug($module) }}">
                <div class="accordion-body">
                    @foreach($groups as $group => $perms)
                        <div class="mb-3 border-bottom pb-2">
                            <div class="d-flex align-items-center mb-2">
                                <input type="checkbox" class="form-check-input me-2" onclick="checkAllPermissions('{{ Str::slug($group) }}');" id="checkall-{{ Str::slug($group) }}" />
                                <label for="checkall-{{ Str::slug($group) }}" class="mb-0 text-primary fw-bold">{{ ucfirst($group) }} - Select All</label>
                            </div>
                            <div class="row">
                                @foreach($perms as $perm)
                                    <div class="col-6 col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                name="permission[]" 
                                                class="form-check-input {{ Str::slug($group) }}" 
                                                id="perm_{{ $perm['id'] }}" 
                                                value="{{ $perm['id'] }}"
                                                {{ in_array($perm['id'], $rolePermissions) ? 'checked' : '' }}>
                                            <label for="perm_{{ $perm['id'] }}" class="form-check-label">{{ $perm['name'] }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
function checkAllPermissions(groupSlug) {
    const checkAllBox = document.getElementById('checkall-' + groupSlug);
    const checkboxes = document.querySelectorAll('.' + groupSlug);

    checkboxes.forEach(cb => {
        cb.checked = checkAllBox.checked;
    });
}
</script>
