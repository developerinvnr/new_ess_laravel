<div class="card">
    <div class="card-header align-items-center d-flex p-2">
        <ol class="breadcrumb m-0 flex-grow-1">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
            <li class="breadcrumb-item active">Employee</li>
        </ol>
        <div class="form-check d-flex align-items-center me-3 gap-1">
            <input class="form-check-input" type="radio" value="" name="employee" id="employeeVNR">
            <label class="form-check-label" for="employeeVNR">
                VNR
            </label>
        </div>
        <div class="form-check d-flex align-items-center me-3 gap-1">
            <input class="form-check-input" type="radio" value="V" name="employee" id="employeeMovedVNR">
            <label class="form-check-label" for="employeeMovedVNR">
                Moved from VVNR
            </label>
        </div>
        <select id="functionSelect" name="function" style="width:150px;" class="form-select form-select-sm me-3"
            aria-label="Select function">
            <option selected="" value="">Function</option>
            <?php foreach ($functions as $function): ?>
            <option value="<?= $function['id'] ?>">
                <?= $function['function_name'] ?> (<?= $function['function_code'] ?>)
            </option>
            <?php endforeach; ?>
        </select>
        <select id="departmentSelect" name="department" style="width:150px;" class="form-select form-select-sm me-3"
            aria-label="Select department">
            <option selected="" value="">Department</option>
            <?php foreach ($departments as $department): ?>
            <option value="<?= $department['id'] ?>">
                <?= $department['department_name'] ?> (<?= $department['department_code'] ?>)
            </option>
            <?php endforeach; ?>
        </select>
        <select id="statusSelect" name="status" style="width:150px;" class="form-select form-select-sm me-3"
            aria-label="Select status">
        
            <option value="A">Active</option>
            <option value="D">Inactive</option>
        </select>
    </div>
    <div class="card-body table-responsive">
        <div id="elmLoader" class="d-none">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <table id="employeeTable" class="table table-bordered align-middle" style="width: 100%;">
            <thead>
                <tr>
                    <th>SR No.</th>
                    <th>E-Code</th>
                    <th>Name</th>
                    <th>Function</th>
                    <th>Vertical</th>
                    <th>Department</th>
                    <th>Grade</th>
                    <th>Date of Join</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    function formatDateToDDMMYYYY(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-GB');
    }
    function showSkeletonLoader(rowCount = 10) {
        let skeletonRows = '';
        for (let i = 0; i < rowCount; i++) {
            skeletonRows += `
                    <tr class="skeleton-loader">
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box"></div></td>
                        <td><div class="skeleton-box" style="width: 60px;"></div></td>
                    </tr>
                `;
        }
        $('#employeeTable tbody').html(skeletonRows);
    }
    function fetchEmployees(filters = {}) {
        showSkeletonLoader(10);
        $.ajax({
            url: 'fetch_employees',
            method: 'GET',
            data: filters,
            success: function(response) {
                if (response.success) {
                    let employees = response.data;
                    let tbody = '';
                    employees.forEach((employee, index) => {
                        let formattedDate = formatDateToDDMMYYYY(employee.DateJoining);
                        var employeeViewUrl = "{{ route('employee.details', ':id') }}";
                        var viewUrl = employeeViewUrl.replace(':id', employee.EmployeeID);
                        tbody += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${employee.EmpCode}</td>
                            <td>${employee.employee_name}</td>
                            <td>${employee.function}</td>
                            <td>${employee.vertical}</td>
                            <td>${employee.department_code}</td>
                            <td>${employee.GradeValue}</td>
                            <td>${formattedDate}</td>
                            <td>${employee.EmpStatus === 'A' ? 
                                '<i class="ri-check-line align-middle text-success"></i> Active' : 
                                '<i class="ri-close-circle-line align-middle text-danger"></i> In-active'}
                            </td>
                            <td>
                                <a target="_blank" href="${viewUrl}">
                                    <span class="badge bg-info-subtle text-info">View</span>
                                </a>
                            </td>   
                        </tr>
                    `;
                    });
                    if ($.fn.DataTable.isDataTable('#employeeTable')) {
                        $('#employeeTable').DataTable().destroy();
                    }
                    $('#employeeTable tbody').html(tbody);
                    $('#employeeTable').DataTable({
                        pageLength: 10,
                        lengthMenu: [5, 10, 25, 50],
                        searching: true,
                        ordering: true,
                        responsive: true,
                        autoWidth: false,
                    });
                } else {
                    console.warn("Error in response:", response.message);
                    $('#employeeTable tbody').html(
                        '<tr><td colspan="10">No data found</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }
    $(document).ready(function() {

        $(document).on('change', '#functionSelect, #departmentSelect, #statusSelect, input[name="employee"]',
            function() {
                let filters = {
                    function: $('#functionSelect').val(),
                    department: $('#departmentSelect').val(),
                    status: $('#statusSelect').val(),
                    vcode: $('input[name="employee"]:checked').val() || '',
                };
                fetchEmployees(filters);
            });
    });
</script>

