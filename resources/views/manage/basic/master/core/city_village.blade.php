<div class="card" id="records-container">
    <div class="card-header align-items-center d-flex p-2">
        <ol class="breadcrumb m-0 flex-grow-1">
            <li class="breadcrumb-item"><a href="javascript: void(0);">Master</a></li>
            <li class="breadcrumb-item active">City / Village</li>
        </ol>
        <div class="flex-shrink-0" style="margin-left:20px;font-size:20px;">
            <input type="text" class="form-control form-control-sm" id="customSearchBox" placeholder="Search..."
                style="width: 200px;">
        </div>
    </div><!-- end card header -->

    <div class="card-body table-responsive" >
        <div id="elmLoader" class="d-none">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <table id="myTable1" class="table table-bordered align-middle" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>City/Village Name</th>
                    <th class="text-center">Pin Code</th>
                    <th class="text-center">Division Name</th>
                    <th>District Name</th>
                    <th>State Name</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th class="text-center">Effective Date</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($city_list as $key => $city)
                    <tr>

                        <td class="text-center">{{ $city_list->firstItem() + $key}}</td>
                        <td>{{ $city->city_village_name }}</td>
                        <td class="text-center">{{ $city->pincode }}</td>
                        <td class="text-center">{{ $city->division_name }}</td>
                        <td>{{ $city->district->district_name }}</td>
                        <td>{{ $city->state->state_name }}</td>
                        <td>{{ $city->longitude }}</td>
                        <td>{{ $city->latitude }}</td>
                        <td class="text-center">
                            <!-- Effective Date -->
                            @if ($city->effective_date)
                                {{ date('d-m-Y', strtotime($city->effective_date)) }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($city->is_active == 1)
                                Yes
                            @else
                                No
                            @endif

                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $city_list->links('pagination::bootstrap-5') }}

    </div>
</div> <!-- .card-->
<script>
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

        let url = $(this).attr('href');
        fetchRecords(url);
    });

    function fetchRecords(url) {
        $.ajax({
            url: url,
            success: function(data) {
                $('#records-container').html(data);
            },
            error: function(xhr) {
                console.log("Error:", xhr);
            }
        });
    }
</script>
