<div class="card">
    <div class="card-header align-items-center d-flex p-2">
        <ol class="breadcrumb m-0 flex-grow-1">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
            <li class="breadcrumb-item active">District</li>
        </ol>


        <div class="flex-shrink-0" style="margin-left:20px;font-size:20px;">
            <input type="text" class="form-control form-control-sm" id="customSearchBox" placeholder="Search..."
                style="width: 200px;">
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
                    <th class="text-center">#</th>
                    <th>District Name</th>
                    <th class="text-center">District Code</th>
                    <th class="text-center">Numeric Code</th>
                    <th>State Name</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($district_list as $district)
                    <tr>

                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $district->district_name }}</td>
                        <td class="text-center">{{ $district->district_code }}</td>
                        <td class="text-center">{{ $district->numeric_code }}</td>
                        <td>{{ $district->state->state_name }}</td>
                        <td class="text-center">
                            <!-- Effective Date -->
                            @if ($district->effective_date)
                                {{ date('d-m-Y', strtotime($district->effective_date)) }}
                            @else
                            N/A
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($district->is_active == 1)
                                Yes
                            @else
                                No
                            @endif

                        </td>

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
