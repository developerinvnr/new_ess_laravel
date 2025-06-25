<table>
    <thead>
        <tr>
            <th>EC</th>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Email</th>
            <th>Resignation Date</th>
            <th>Relieving Date</th>
            <th>Resignation Approved</th>
            <th>Reporting Approved</th>
            <th>Clearance Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($approvedEmployees as $data)
        <tr>
            <td>{{ $data->EmpCode }}</td>
            <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td>
            <td>{{ $data->department_name }}</td>
            <td>{{ $data->EmailId_Vnr }}</td>
            <td>{{ $data->Emp_ResignationDate ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('d-m-Y') : 'Not specified' }}</td>
            <td>{{ $data->Emp_RelievingDate ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('d-m-Y') : 'Not specified' }}</td>
            <td>{{ $data->Rep_Approved == 'Y' ? 'Approved' : 'Pending' }}</td>
            <td>{{ $data->Rep_NOC == 'Y' ? 'Approved' : 'Pending' }}</td>
            <td>{{ $data->Log_NOC == 'Y' ? 'Submitted' : 'Pending' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
