<table>
    <thead>
        <tr>
            <th>SN.</th>
            <th>EC</th>
            <th>Name</th>
            <th>Department</th>
            <th>Grade</th>
            <th>Last Rating</th>
            <th>Employee Score/Rating</th>
            <th>Appraiser Score/Rating</th>
            <th>Reviewer Score/Rating</th>
            <th>HOD Score</th>
            <th>Management Score</th>
            <th>Management Rating</th>
            <th>Management Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach($details as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $row->EmpCode }}</td>
            <td>{{ $row->Fname }} {{ $row->Sname }} {{ $row->Lname }}</td>
            <td>{{ $row->department_name }}</td>
            <td>{{ $row->grade_name }}</td>
            <td>{{ $row->FirstRating ?? '-' }}</td>
            <td>{{ $row->Emp_TotalFinalScore }}/{{ $row->Emp_TotalFinalRating }}</td>
            <td>{{ $row->Appraiser_TotalFinalScore }}/{{ $row->Appraiser_TotalFinalRating }}</td>
            <td>{{ $row->Reviewer_TotalFinalScore }}/{{ $row->Reviewer_TotalFinalRating }}</td>
            <td>{{ $row->Hod_TotalFinalScore }}</td>
            <td>{{ $row->Hod_TotalFinalScore }}</td>
            <td>{{ $row->Hod_TotalFinalRating }}</td>
            <td>{{ $row->HodRemark }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
