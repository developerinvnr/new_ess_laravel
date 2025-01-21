$('#statusFilter').change(function() {
    var status = $(this).val();
    var page = 1;  // Reset to page 1 when filter is changed

    // Make AJAX request
    $.ajax({
        url: "{{ route('logistics.clearance') }}", // Update the route accordingly
        type: 'GET',
        data: {
            status: status,
            page: page
        },
        success: function(response) {
            // Update the table with the new rows and pagination
            $('#tableBody').html(response.tableData);
            $('#pagination').html(response.pagination);
        }
    });
});

$('#statusFilter').change(function() {
            var selectedStatus = $(this).val();

            // Send AJAX request to filter data based on selected status
            $.ajax({
                url: "{{ route('logistics.clearance') }}", // Route for the logisticsClearance method
                type: "GET",
                data: {
                    status: selectedStatus // Send the selected status as a parameter
                },
                success: function(response) {
                    console.log(response);
                     // Update the table rows with the new data
                     $('#logisticstable tbody').html($(response.tableData).find('tbody').html());
                    
                    // Update the pagination links
                    $('.pagination-container').html(response.pagination);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });