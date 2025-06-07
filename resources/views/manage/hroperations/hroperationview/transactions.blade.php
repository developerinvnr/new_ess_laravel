<div class="row">
    <!-- RIGHT SIDE TABLE -->
    <div class="col">
        <div class="h-100">
            <div class="card">
                <div class="card-header align-items-center d-flex p-2">
                    <ol class="breadcrumb m-0 flex-grow-1">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Master Type</a></li>
                        <li class="breadcrumb-item active">Transaction</li>
                    </ol>
                    <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2"
                        data-bs-toggle="modal" data-bs-target="#AddTranModal">
                        <i class="ri-add-line align-bottom me-1"></i> Add New Transaction
                    </button>
                    <!-- <div class="flex-shrink-0" style="font-size:16px;">
                        <a class="me-2" href=""><i class="las la-file-pdf"></i></a>
                        <a class="me-2" href=""><i class="las la-file-excel"></i></a>
                        <a class="me-2" href=""><i class="las la-file-csv"></i></a>
                    </div> -->
                </div>

                <div class="card-body table-responsive">
                    <div id="successMsg" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                        <span class="message-text"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <table id="companytable" class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>SR No.</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Created By</th>
                                <th>Update By</th>
                                <th>Create Date</th>
                                <th>Updated Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Existing rows -->
                            @foreach($transactions as $index => $tran)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $tran->name }}</td>
                                <td data-parentid="{{ $tran->parentid }}">{{ $tran->parent?->name ?? '-' }}</td>
                                <td>{{ $tran->creator ? $tran->creator->Fname . ' ' . $tran->creator->Sname . ' ' . $tran->creator->Lname : '-' }}</td>
                                <td>{{ $tran->updater ? $tran->updater->Fname . ' ' . $tran->updater->Sname . ' ' . $tran->updater->Lname : '-' }}</td>
                                <td>{{ $tran->created_at ? $tran->created_at->format('d-m-Y') : '-' }}</td>
                                <td>{{ $tran->updated_at ? $tran->updated_at->format('d-m-Y') : '-' }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" disabled {{ $tran->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $tran->status == 1 ? 'Active' : 'De-active' }}</label>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-link text-success save-btn d-none" title="Save"><i class="ri-save-line"></i></button>
                                    <button class="btn btn-sm btn-link text-primary edit-btn" data-id="{{ $tran->id }}" title="Edit"><i class="bx bx-pencil"></i></button>
                                    <button class="btn btn-sm btn-link text-danger delete-btn" data-id="{{ $tran->id }}" title="Delete"><i class="bx bx-trash"></i></button>
                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add master Modal -->
<div class="modal fade" id="AddTranModal" tabindex="-1" aria-labelledby="AddTranModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="transactionForm">
                @csrf
                <div class="modal-header bg-light">
                    <h5 class="modal-title">Add New Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    
                    <div id="errorMsg" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                        <span class="message-text"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Parent</label>
                            <!-- <select name="parentid" class="form-select form-select-sm">
                                <option value="">Select</option>
                                @foreach($transactions as $transaction)
                                <option value="{{ $transaction->id }}">{{ $transaction->name }}</option>
                                @endforeach
                            </select> -->

                            <select name="parentid" id="parentidSelect" class="form-select form-select-sm">
                                <option value="">Select</option>
                            </select>

                        </div>
                        <div class="col-md-6 mt-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select form-select-sm" required>
                                <option value="">Select</option>
                                <option value="1">Active</option>
                                <option value="0">De-active</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;

        fetch("{{ route('transactions.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => response.json())
            .then(res => {
                const errorBox = document.getElementById('errorMsg');
                const msg = document.getElementById('successMsg');
                console.log(res);
                if (res.error) {
                    errorBox.textContent = res.error;
                    errorBox.classList.remove('d-none');
                    submitBtn.disabled = false;
                    return;
                }


                if (res.success) {
                    // Hide error if previously shown
                    errorBox.classList.add('d-none');

                                // Show success message above table
                    const messageElement = msg.querySelector('.message-text');
                    console.log('messageElement:', messageElement); // Debug line

                    if (messageElement) {
                        messageElement.textContent = res.success;
                    } else {
                        console.warn('.message-text not found inside #successMsg. Setting text directly on #successMsg.');
                        msg.textContent = res.success;
                    }

                    msg.classList.remove('d-none');
                    setTimeout(() => {
                        msg.classList.add('d-none');
                    }, 3000);


                    // Close modal
                    const modalEl = document.getElementById('AddTranModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    // Reset form
                    form.reset();
                    submitBtn.disabled = false;

                    // Add new row to table
                    const table = document.querySelector('#companytable tbody');
                    const rowCount = table.rows.length + 1;
                    const newRow = `
                    <tr>
                        <td>${rowCount}</td>
                        <td>${res.data.name}</td>
                        <td data-parentid="${res.data.parentid}">${res.data.parent_name || ''}</td>
                        <td>${res.data.created_by_name}</td>
                        <td>${res.data.updated_by_name}</td>
                        <td>${res.data.created_at}</td>
                        <td>${res.data.updated_at}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" disabled ${res.data.status == 1 ? 'checked' : ''}>
                                <label class="form-check-label">${res.data.status == 1 ? 'Active' : 'De-active'}</label>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-link text-success save-btn d-none" title="Save"><i class="ri-save-line"></i></button>
                            <button class="btn btn-sm btn-link text-primary edit-btn" data-id="${res.data.id}" title="Edit"><i class="bx bx-pencil"></i></button>
                            <button class="btn btn-sm btn-link text-danger delete-btn" data-id="${res.data.id}" title="Delete"><i class="bx bx-trash"></i></button>
                        
                        </td>
                    </tr>`;
                    table.insertAdjacentHTML('beforeend', newRow);

                    // Add new option to dropdown
                    const parentDropdowns = document.querySelectorAll('select[name="parentid"]');
                    parentDropdowns.forEach(drop => {
                        const opt = document.createElement('option');
                        opt.value = res.data.id;
                        opt.textContent = res.data.name;
                        drop.appendChild(opt);
                    });
                }
            })
            .catch(err => {
                alert("Something went wrong.");
                console.error(err);
                submitBtn.disabled = false;
            });
    });

    $(document).on('click', '.edit-btn', function() {
        const row = $(this).closest('tr');
        row.addClass('editing');

        // Toggle buttons
        row.find('.save-btn').removeClass('d-none');
        $(this).addClass('d-none');

        // Get current values
        const nameVal = row.find('td').eq(1).text().trim();
        console.log(nameVal);
        const currentParentId = row.find('td').eq(2).data('parentid') || '';
        const isChecked = row.find('input[type="checkbox"]').is(':checked');

        // Replace name with input
        row.find('td').eq(1).html(`<input type="text" class="form-control form-control-sm edit-name" value="${nameVal}">`);

        // Fetch latest parent options via AJAX
        $.getJSON("{{ route('parent.options') }}", function(parentOptions) {
            let parentSelect = `<select class="form-select form-select-sm edit-parent"><option value="">-- Select --</option>`;
            $.each(parentOptions, function(id, name) {
                parentSelect += `<option value="${id}" ${id == currentParentId ? 'selected' : ''}>${name}</option>`;
            });
            parentSelect += `</select>`;
            row.find('td').eq(2).html(parentSelect);
        });

        // Replace status with editable toggle
        row.find('td').eq(7).html(`
        <div class="form-check form-switch">
            <input class="form-check-input edit-status" type="checkbox" ${isChecked ? 'checked' : ''}>
            <label class="form-check-label">${isChecked ? 'Active' : 'De-active'}</label>
        </div>
        `);
    });

    $(document).on('click', '.save-btn', function() {
        const row = $(this).closest('tr');
        const id = row.find('.edit-btn').data('id');
        const name = row.find('.edit-name').val();
        const parentid = row.find('.edit-parent').val();
        const status = row.find('.edit-status').is(':checked') ? 1 : 0;
        const url = '{{ route("transactions.update", ":id") }}'.replace(':id', id);

        $.ajax({
            url: url,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            contentType: 'application/json',
            data: JSON.stringify({
                name,
                parentid,
                status
            }),
            success: function(res) {
                if (res.success) {
                    $.getJSON("{{ route('parent.options') }}", function(latestParentOptions) {
                        const data = res.data;

                        const parentName = latestParentOptions[data.parentid] || '-';
                        row.find('td').eq(1).text(data.name); // Name
                        row.find('td').eq(2).text(parentName).data('parentid', data.parentid); // Parent

                        row.find('td').eq(3).text(data.created_by_name || '-');
                        row.find('td').eq(4).text(data.updated_by_name || '-');
                        row.find('td').eq(5).text(data.updated_at || '-');

                        const statusHtml = `
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" disabled ${data.status == 1 ? 'checked' : ''}>
                            <label class="form-check-label">${data.status == 1 ? 'Active' : 'De-active'}</label>
                        </div>
                    `;
                        row.find('td').eq(7).html(statusHtml);

                        row.find('.save-btn').addClass('d-none');
                        row.find('.edit-btn').removeClass('d-none');
                        row.removeClass('editing');
                        console.log(data.mainid)

                        // ✅ Update affected child rows
                        if (Array.isArray(data.mainid)) {
                            $('#companytable tbody tr').each(function() {
                                const childRow = $(this);
                                const parentId = childRow.find('td').eq(2).data('parentid');
                                if (data.mainid.includes(parentId)) {
                                    childRow.find('td').eq(2).text(data.name);

                                    const childStatusHtml = `
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" disabled ${data.status == 1 ? 'checked' : ''}>
                                        <label class="form-check-label">${data.status == 1 ? 'Active' : 'De-active'}</label>
                                    </div>
                                `;
                                    childRow.find('td').eq(7).html(childStatusHtml);
                                }
                            });
                        }

                        // ✅ Update dropdowns if needed
                        $('select[name="parentid"]').each(function() {
                            $(this).find(`option[value="${data.id}"]`).text(data.name);
                        });
                    });
                } else {
                    alert(res.error || 'Update failed.');
                }
            },
            error: function() {
                alert('Something went wrong.');
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        const btn = $(this);
        const id = btn.data('id');

        if (!confirm('Are you sure you want to delete this transaction and its children?')) return;

        const url = '{{ route("transactions.destroy", ":id") }}'.replace(':id', id);

        $.ajax({
            url: url,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (res) {
                if (res.success) {
                    // Remove the deleted row
                    const row = btn.closest('tr');
                    const deletedParentId = row.find('td').eq(2).data('parentid') || id;
                    row.remove();

                    // Remove any child rows
                    $('#companytable tbody tr').each(function () {
                        const childRow = $(this);
                        const parentId = childRow.find('td').eq(2).data('parentid');
                        if (parentId == id) {
                            childRow.remove();
                        }
                    });

                    // Remove from dropdowns
                    $('select[name="parentid"] option[value="' + id + '"]').remove();

                    // ✅ Recalculate and update SR No. for all remaining rows
                    $('#companytable tbody tr').each(function (index) {
                        $(this).find('td').eq(0).text(index + 1);
                    });

                    // Optional: Show success message
                    $('#successMsg').text(res.success).removeClass('d-none');

                    setTimeout(() => {
                    $('#successMsg').addClass('d-none');
                    }, 3000);
                }
            },
            error: function () {
                alert('Failed to delete transaction.');
            }
        });
    });

document.getElementById('AddTranModal').addEventListener('show.bs.modal', function () {
    const form = document.getElementById('transactionForm');
    const successMsg = document.getElementById('successMsg');
    const errorMsg = document.getElementById('errorMsg');
    const select = document.getElementById('parentidSelect');

    // Reset the form
    form.reset();

    // Hide any messages
    if (successMsg) successMsg.classList.add('d-none');
    if (errorMsg) errorMsg.classList.add('d-none');

    // Clear the message text inside if applicable
    const successText = successMsg?.querySelector('.message-text');
    if (successText) successText.textContent = '';

    // Clear old select options and add default
    select.innerHTML = '<option value="">Select</option>';

    // Fetch new options
    fetch("{{ route('parent.options.modal') }}")
        .then(response => response.json())
        .then(data => {
            console.log(data);
            data.forEach(function (transaction) {
                const option = document.createElement('option');
                option.value = transaction.id;
                option.textContent = transaction.name;
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error loading parent options:", error);
        });
});


</script>