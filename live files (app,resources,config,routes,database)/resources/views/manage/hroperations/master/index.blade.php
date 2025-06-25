@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div style="padding-top:5px;padding-bottom: 5px;"
                    class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <!--<h4 class="mb-sm-0">Basic</h4>-->

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="las la-home"></i></a></li>
                            <li class="breadcrumb-item active">HR Operations</li>
                            <li class="breadcrumb-item active">Master</li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @include('manage.hroperations.hroperation_widget')
        <div class="row">
            @include('manage.hroperations.master.hroperations_master_sidebar')
            <div class="col-xl-10" id="child-content">
            </div>
        </div>
    </div>
@endsection
@section('script_section')
    <script>
        $(document).ready(function() {

            // Attach click event to sidebar items
            $('.sidebar-item').on('click', function() {
                const url = $(this).data('url'); // Get the URL from data-url attribute

                // Show a loading message in #child-content
                $('#child-content').html('<p>Loading...</p>');

                // Perform AJAX call
                $.ajax({
                    url: url, // URL from the clicked item's data-url attribute
                    method: 'GET', // HTTP method
                    success: function(response) {
                        // Inject the response into the #child-content div
                        $('#child-content').html(response);
                        // Reinitialize DataTables for the new table
                        var table = $('#myTable').DataTable({
                            ordering: false,
                            searching: true,
                            info: true,
                            pageLength: parseInt($('#pageLengthSelector')
                                .val()), // Set initial page length from the selector
                            lengthChange: false, // Disable default length change
                            dom: "til" // Disable the default DataTable controls

                        });
                        // Handle page length change
                        $('#pageLengthSelector').on('change', function() {
                            var newLength = parseInt($(this).val());
                            table.page.len(newLength)
                                .draw(); // Update page length and redraw table
                            updatePagination
                                (); // Update pagination after page length change
                        });
                        $('#customSearchBox').on('keyup', function() {
                            table.search(this.value).draw();
                        });
                        // Function to update custom pagination
                        function updatePagination() {
                            var info = table.page.info();
                            var currentPage = info.page + 1;
                            var totalPages = info.pages;
                            var displayRange = 1;
                            var startPage = Math.max(1, currentPage - displayRange);
                            var endPage = Math.min(totalPages, currentPage + displayRange);

                            var paginationHTML = '';
                            paginationHTML += '<li class="page-item pagination-first ' + (
                                    currentPage === 1 ? 'disabled' : '') +
                                '"><a href="#">First</a></li>';
                            paginationHTML += '<li class="page-item pagination-prev ' + (
                                    currentPage === 1 ? 'disabled' : '') +
                                '"><a href="#">Previous</a></li>';

                            for (var i = startPage; i <= endPage; i++) {
                                paginationHTML += '<li class="page-item ' + (i === currentPage ?
                                        'active' : '') +
                                    '"><a class="page" href="#" data-page="' + (i - 1) + '">' +
                                    i + '</a></li>';
                            }

                            paginationHTML += '<li class="page-item pagination-next ' + (
                                currentPage === totalPages ?
                                'disabled' : '') + '"><a href="#">Next</a></li>';
                            paginationHTML += '<li class="page-item pagination-last ' + (
                                currentPage === totalPages ?
                                'disabled' : '') + '"><a href="#">Last</a></li>';

                            $('.pagination.listjs-pagination').html(paginationHTML);
                        }

                        // Handle custom pagination link clicks
                        $(document).on('click', '.pagination a.page', function(e) {
                            e.preventDefault();
                            var page = $(this).data('page');
                            table.page(page).draw('page');
                            updatePagination();
                        });

                        $(document).on('click', '.pagination-prev', function(e) {
                            e.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                table.page('previous').draw('page');
                                updatePagination();
                            }
                        });

                        $(document).on('click', '.pagination-next', function(e) {
                            e.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                table.page('next').draw('page');
                                updatePagination();
                            }
                        });

                        $(document).on('click', '.pagination-first', function(e) {
                            e.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                table.page(0).draw('page');
                                updatePagination();
                            }
                        });

                        $(document).on('click', '.pagination-last', function(e) {
                            e.preventDefault();
                            if (!$(this).hasClass('disabled')) {
                                table.page(table.page.info().pages - 1).draw('page');
                                updatePagination();
                            }
                        });

                        updatePagination(); // Initial call to update pagination on load
                    },
                    error: function(xhr, status, error) {
                        // Show an error message on failure
                        $('#child-content').html(
                            '<p>Error loading page. Please try again.</p>');
                        console.error(`Error: ${error}`); // Log error for debugging
                    }
                });
            });

            $(document).on('click', '#syncAPI', function() {
                $.ajax({
                    url: "{{ route('core_api_sync') }}",
                    method: 'GET',
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $("#elmLoader").removeClass('d-none')
                    },
                    success: function(data) {
                        if (data.status == 200) {
                            $("#elmLoader").addClass('d-none');
                            toastr.success(data.msg);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            $("#elmLoader").addClass('d-none');
                            toastr.error(data.msg);
                        }
                    }
                });

            });
            $(document).on('click', '#import-actions', function() {
                var api_end_points = [];

                $("input[name='apis']").each(function() {
                    if ($(this).prop("checked") === true) {
                        var value = $(this).val();
                        api_end_points.push(value);
                    }
                });
                if (api_end_points.length > 0) {
                    if (confirm('Are you sure to import selected api data?')) {
                        $.ajax({
                            url: "{{ route('importAPISData') }}",
                            type: 'POST',
                            data: {
                                api_end_points: api_end_points,
                                _token: "{{ csrf_token() }}",
                            },
                            beforeSend: function() {
                                $("#elmLoader").removeClass('d-none')
                            },
                            success: function(data) {
                                $("#elmLoader").addClass('d-none');
                                if (data.status === 400) {
                                    toastr.error("Something went wrong!");
                                } else {
                                    toastr.success("Data Imported Successfully");
                                }
                            }
                        });
                    }

                } else {
                    alert('No API Selected!\nPlease select atleast one api to proceed.');
                }

            });

        });
    </script>
    <script></script>
@endsection
