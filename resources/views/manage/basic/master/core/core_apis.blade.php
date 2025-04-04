<div class="card">
    <div class="card-header align-items-center d-flex p-2">
        <ol class="breadcrumb m-0 flex-grow-1">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
            <li class="breadcrumb-item active">Core API's</li>
        </ol>
        <button class="btn btn-sm btn-soft-success" id="import-actions" style="margin-right:20px;"><i
                class=" ri-download-cloud-2-line"></i> Import</button>
        <input type="text" class="form-control form-control-sm" id="customSearchBox" placeholder="Search..."
            style="width: 200px;">
        <div class="flex-shrink-0" style="margin-left:20px;font-size:20px;">
            <button class="btn btn-sm btn-light" title="Sync Core API" id="syncAPI"> <i class="las la la-sync"></i>
                Sync API</button>
        </div>
    </div><!-- end card header -->

    <div class="card-body table-responsive">
        <div id="elmLoader" class="d-none">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <table id="myTable" class="table table-bordered align-middle" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">
                        <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                    </th>
                    <th class="text-center">#</th>
                    <th>API Name</th>
                    <th>API End Point</th>
                    <th>Parameter</th>
                    <th>Description</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($api_list as $api)
                    <tr>
                        <td class="text-center">
                            <input type="checkbox" name="apis" id="apis_{{ $loop->iteration }}"
                                value="{{ $api->api_end_point }}">
                        </td>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $api->api_name }}</td>
                        <td>{{ $api->api_end_point }}</td>
                        <td>{{ $api->parameters }}</td>
                        <td>{{ $api->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- No Results Message -->
        <div class="noresult">
            <div class="text-center">
                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                    colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                <h5 class="mt-2">Sorry! No Result Found</h5>

            </div>
        </div>

        <!-- Custom Pagination -->
        <div class="d-flex justify-content-end mt-3">
            <!-- Page Length Selector -->
            <select id="pageLengthSelector" class="form-select form-select-sm me-3" style="width: auto;">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <div class="pagination-wrap hstack gap-2" style="display: flex;">
                <ul class="pagination listjs-pagination mb-0"></ul>
            </div>
        </div>
    </div>
</div> <!-- .card-->
