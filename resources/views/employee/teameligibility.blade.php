@include('employee.head')
@include('employee.header')
@include('employee.sidebar')

<body class="mini-sidebar">
    <div class="loader" style="display: none;">
        <div class="spinner" style="display: none;">
            <img src="./SplashDash_files/loader.gif" alt="">
        </div> 
    </div>
    
    <!-- Main Body -->
    <div class="page-wrapper">
        <div class="main-content">
            <!-- Page Title Start -->
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-title-wrapper">
                        <div class="breadcrumb-list">
                            <ul>
                                <li class="breadcrumb-link">
                                    <a href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
                                </li>
                                <li class="breadcrumb-link active">My Team</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Start -->
            @include('employee.menuteam')

            <!-- Loop through employee eligibility data -->
            @foreach($eligibility as $index => $eligibilityData)
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 employee-card" data-employeeid="{{ $eligibilityData->EmployeeID }}" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                    <div class="card chart-card">
                        <div class="card-header eligibility-head-title d-flex align-items-center">
                            <h5 class="mr-3"><b>Employee Eligibility for: {{ $eligibilityData->Fname }} {{ $eligibilityData->Sname }} {{ $eligibilityData->Lname }} (ID: {{ $eligibilityData->EmployeeID }})</b></h5>
                            <!-- Dropdown for selecting employee (Aligned Right) -->
                            <select class="employeeSelect form-control ml-auto" style="max-width: 340px;">
                                <option value="">Select Employee</option>
                                @foreach($eligibility as $employee)
                                    <option value="{{ $employee->EmployeeID }}" data-index="{{ $loop->index }}" {{ $eligibilityData->EmployeeID == $employee->EmployeeID ? 'selected' : '' }}>
                                        {{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }} (ID: {{ $employee->EmployeeID }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="card-body align-items-center">
                            <!-- Lodging Entitlements Table -->
                            <h5>Lodging Entitlements (Actual with upper limits per day)</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>City Category A:</th>
                                        <td>{{$eligibilityData->Lodging_CategoryA ?? 'N/A'}}/-</td>
                                    </tr>
                                    <tr>
                                        <th>City Category B:</th>
                                        <td>{{$eligibilityData->Lodging_CategoryB ?? 'N/A'}}/-</td>
                                    </tr>
                                    <tr>
                                        <th>City Category C:</th>
                                        <td>{{$eligibilityData->Lodging_CategoryC ?? 'N/A'}}/-</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Daily Allowances Table -->
                            <h5>Daily Allowances</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>DA@HQ:</th>
                                        <td>{{ $eligibilityData->DA_Inside_Hq > 0 ? $eligibilityData->DA_Inside_Hq : '0.00' }}/- Per Day</td>
                                    </tr>
                                    <tr>
                                        <th>DA Outside HQ:</th>
                                        <td>{{$eligibilityData->DA_Outside_Hq ?? 'N/A'}}/- Per Day</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5>Insurance (Sum Insured)</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Health Insurance:</th>
                                        <td>{{$eligibilityData->Health_Insurance ?? 'N/A'}}/-</td>
                                    </tr>
                                    <tr>
                                        <th>Group Term Life Insurance:</th>
                                        <td>{{$eligibilityData->Term_Insurance ?? 'N/A'}}/-</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5>Mobile Eligibility (Subject to submission of bills)</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Handset:</th>
                                        <td>{{$eligibilityData->Mobile_Exp_Rem_Rs ?? 'N/A'}} <span style="font-size: 12px;">(Once in 2 yrs)</span></td>
                                    </tr>
                                </tbody>
                            </table>

                            <h5>Gratuity / Deduction</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Gratuity:</th>
                                        <td>AS per Law</td>
                                    </tr>
                                    <tr>
                                        <th>Deduction:</th>
                                        <td>AS per Law</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="color: #686464;">(Provident Fund/ ESIC/ Tax on Employment/ Income Tax/ Any dues to company (if any)/ Advances)</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

@include('employee.footer')

<script>
// JavaScript to Handle Dropdown Change
document.querySelectorAll('.employeeSelect').forEach(function(dropdown) {
    dropdown.addEventListener('change', function() {
        var selectedEmployeeId = this.value;

        // Hide all employee cards initially
        var employeeCards = document.querySelectorAll('.employee-card');
        employeeCards.forEach(function(card) {
            card.style.display = 'none';  // Hide all employee cards initially
        });

        // Show the selected employee's card
        if (selectedEmployeeId) {
            var selectedCard = document.querySelector('.employee-card[data-employeeid="' + selectedEmployeeId + '"]');
            if (selectedCard) {
                selectedCard.style.display = 'block';  // Show the corresponding employee's card
            }
        }

        // Update the dropdown's selected value after displaying the correct card
        var options = this.querySelectorAll('option');
        options.forEach(function(option) {
            if (option.value === selectedEmployeeId) {
                option.selected = true;  // Mark the option as selected
            } else {
                option.selected = false;  // Deselect the other options
            }
        });
    });

    // Initialize dropdown with the first visible employee's card
    var firstVisibleEmployee = document.querySelector('.employee-card[style*="block"]');
    if (firstVisibleEmployee) {
        var firstEmployeeId = firstVisibleEmployee.getAttribute('data-employeeid');
        var firstOption = dropdown.querySelector('option[value="' + firstEmployeeId + '"]');
        if (firstOption) {
            firstOption.selected = true;  // Select the first visible employee
        }
    }
});
</script>
