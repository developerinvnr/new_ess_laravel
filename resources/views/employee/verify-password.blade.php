@include('employee.header')

<body class="mini-sidebar">
    @include('employee.sidebar')
    <div id="loader" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Main Body -->
    <div class="page-wrapper">
        <!-- Header Start -->
        @include('employee.head')
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="{{route('dashboard')}}"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">Verify Password</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                   
                    <div class="card col-md-4 shadow">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0 text-white">Verify Password</h4>
                                    </div>
                                    <div class="card-body">
                                    <form id="passwordForm">
                                @csrf
                                <div class="form-group">
                                    <label for="password">Enter your login password:</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <button type="button" class="btn btn-primary" id="submitPassword">Submit</button>
                            </form>
                            </div>
                    </div>
                </div>

                       
                    </div>

                </div>
          

                @include('employee.footerbottom')
            </div>
        </div>
    </div>
    


    @include('employee.footer')


<script>
    $('#passwordForm').on('submit', function (event) {
        event.preventDefault(); // Prevent the default form submission

        var password = $('#password').val();
        const verifyPassword = "{{ route('verifyPassword.submit') }}"; // The route URL for password verification

        $('#loader').show(); // Show loader

        $.ajax({
            url: verifyPassword, // Use the route URL from your server
            method: 'POST',
            data: {
                "_token": "{{ csrf_token() }}", // CSRF token for security
                password: password
            },
            success: function (response) {
                $('#loader').hide(); // Hide loader

                if (response.success) {
                    // Display success message using toastr
                    toastr.success(response.message, 'Success', {
                        "positionClass": "toast-top-right", // Position the toast in the top-right corner
                        "timeOut": 3000 // Duration for which the toast is visible (in milliseconds)
                    });

                    // Redirect after the toast disappears (e.g., after 3 seconds)
                    setTimeout(function () {
                        window.location.href = "{{ route('salary') }}"; // Redirect to the salary page
                    }, 3000); // Wait for 3 seconds before redirection
                } else {
                    // Display error message
                    toastr.error(response.message, 'Error', {
                        "positionClass": "toast-top-right",
                        "timeOut": 3000
                    });
                }
            },
            error: function () {
                // Handle AJAX error
                $('#loader').hide(); // Hide loader
                alert('An error occurred. Please try again later.');
            }
        });
    });

    // Handle Enter keypress in the password input field
    $('#password').keydown(function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent default Enter behavior
            $('#passwordForm').submit(); // Trigger the form submission programmatically
        }
    });
</script>
<style>
    #loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.spinner-border {
    width: 3rem;
    height: 3rem;
}
</style>