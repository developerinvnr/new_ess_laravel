<table>
    <thead>
        <tr>
            <th>EmpCode</th>
            <th>Full Name</th>
            <th>Department</th>
            <th>Email</th>
            @if($type == 'queried')
                <th>Query Date</th>
                <th>Status</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $row)
        @php
                $statusLabels = [
                    0 => 'Open',
                    1 => 'In Process',
                    2 => 'Answer',
                    3 => 'Closed',
                    4 => 'Escalate',
                ];
            @endphp
            <tr>
                <td>{{ $row->EmpCode }}</td>
                <td>{{ $row->full_name }}</td>
                <td>{{ $row->department_name }}</td>
                <td>{{ $row->EmailId_Vnr }}</td>
                @if($type == 'queried')
                    <td>{{ \Carbon\Carbon::parse($row->QueryRaisedAt)->format('d-m-Y') }}</td>
                    <td>{{ $statusLabels[$row->status] ?? 'Unknown' }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
