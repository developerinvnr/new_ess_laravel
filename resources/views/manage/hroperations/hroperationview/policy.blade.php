<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header align-items-center d-flex p-2">
                <ol class="breadcrumb m-0 flex-grow-1">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Type</a></li>
                    <li class="breadcrumb-item active">Policy</li>
                </ol>
                <button type="button" class="btn btn-sm btn-success waves-effect waves-light me-2" data-bs-toggle="modal" data-bs-target="#AddTranModal"><i class="ri-add-line align-bottom me-1"></i> Add New</button>
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
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>test</td>
                            <td><span class="badge bg-success-subtle text-success">Active</span></td>
                            <td><a data-bs-toggle="modal" data-bs-target="#AddTranModal" href=""><i class="ri-edit-line"></i></a></td>

                        </tr>

                    </tbody>
                </table>

            </div>
        </div> <!-- .card-->
    </div> <!-- .col-->
</div>