<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Eligibility</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Employee Eligibility Check</h2>

    <form action="{{ route('employee.checkEligibility') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date:</label>
            <input type="date" id="joining_date" name="joining_date" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="fixed_salary" class="form-label">Fixed Salary:</label>
            <input type="number" id="fixed_salary" name="fixed_salary" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="variable_pay" class="form-label">Variable Pay:</label>
            <input type="number" id="variable_pay" name="variable_pay" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Check Eligibility</button>
    </form>

    @if(isset($eligible))
        <div class="mt-4">
            <h3>Results:</h3>
            <p><strong>Salary Structure:</strong> {{ $salaryStructure }}</p>
            <p><strong>Total Salary:</strong> ${{ number_format($totalSalary, 2) }}</p>
            <p><strong>Eligibility Status:</strong> 
                <span class="badge {{ $eligible ? 'bg-success' : 'bg-danger' }}">
                    {{ $eligible ? 'Eligible' : 'Not Eligible' }}
                </span>
            </p>
        </div>
    @endif

</body>
</html>
