<table class="table">
    <thead>
        <tr>
            <th rowspan="2">SN.</th>
            <th colspan="4">Employee</th>
            <th colspan="2">Appraiser [Proposed]</th>
            <th colspan="2">Reviewer [Proposed]</th>
            <th colspan="3">Management [Proposed]</th>
            <th rowspan="2">Action</th>
        </tr>
        <tr>
            <th>EC</th>
            <th>Name</th>
            <th>Department</th>
            <th>Grade</th>
            <th>Designation</th>
            <th>Grade</th>
            <th>Designation</th>
            <th>Grade</th>
            <th>Designation</th>
            <th>Grade</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $key => $employee)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $employee->EmpCode }}</td>
                <td>{{ $employee->Fname }} {{ $employee->Sname }} {{ $employee->Lname }}</td>
                <td>{{ $employee->department_name }}</td>
                <td>{{ $employee->grade_name }}</td>
                <td>{{ $employee->Appraiser_Designation ?? '-' }}</td>
                <td>{{ $employee->Appraiser_Grade ?? '-' }}</td>
                <td>{{ $employee->Reviewer_Designation ?? '-' }}</td>
                <td>{{ $employee->Reviewer_Grade ?? '-' }}</td>
                <td>{{ $employee->HR_Designation ?? '-' }}</td>
                <td>{{ $employee->HR_Grade ?? '-' }}</td>
                <td>-</td> {{-- Remarks --}}
                <td>-</td> {{-- Action --}}
            </tr>
        @endforeach
    </tbody>
</table>
<style>
    table th {
        background-color: #d9e1f2;
        text-align: center;
        vertical-align: middle;
        font-weight: bold;
        font-size: 14px;
        border: 1px solid #ccc;
        padding: 8px;
    }
    table td {
        border: 1px solid #ccc;
        padding: 6px;
        font-size: 13px;
    }
</style>
