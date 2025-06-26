<table>
    <thead>
        <tr>
            <th>EC</th>
            <th>Employee Name</th>
            <th>Type of Assets</th>
            <th>Req Date</th>
            <th>Balance Amount</th>
            <th>Requested Amount</th>
            <th>Acct. Approval Amount</th>
            <th colspan="3">Approval Status</th>
            <th>Reporting Remark</th>
            <th>Approval Date</th>

        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>HOD</th>
            <th>IT</th>
            <th>Account</th>
            <th></th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($records as $r)
            <tr>
                <td>{{ $r->EmpCode }}</td>
                <td>{{ $r->Fname . ' ' . $r->Sname . ' ' . $r->Lname }}</td>
                <td>{{ $r->AssetName }}</td>
                <td>{{ \Carbon\Carbon::parse($r->ReqDate)->format('d-m-Y') }}</td>
                <td>{{ is_numeric($r->MaxLimitAmt) ? number_format((float) $r->MaxLimitAmt) : '0' }}</td>
                <td>{{ is_numeric($r->ReqAmt) ? number_format((float) $r->ReqAmt) : '0' }}</td>
                <td>{{ is_numeric($r->ApprovalAmt) ? number_format((float) $r->ApprovalAmt) : '0' }}</td>
                <td>
                    @switch($r->HODApprovalStatus)
                        @case(2) Approved @break
                        @case(0) Draft @break
                        @case(3) Rejected @break
                        @default N/A
                    @endswitch
                </td>
                <td>
                    @switch($r->ITApprovalStatus)
                        @case(2) Approved @break
                        @case(0) Draft @break
                        @case(3) Rejected @break
                        @default N/A
                    @endswitch
                </td>
                <td>
                    @switch($r->AccPayStatus)
                        @case(2) Approved @break
                        @case(0) Draft @break
                        @case(3) Rejected @break
                        @default N/A
                    @endswitch
                </td>
                <td>{{ $r->HODRemark }}</td>
                <td>{{ $r->HODSubDate ? \Carbon\Carbon::parse($r->HODSubDate)->format('d-m-Y') : '' }}</td>
      
            </tr>
        @endforeach
    </tbody>
</table>
