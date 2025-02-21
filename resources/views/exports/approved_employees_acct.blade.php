<table class="table table-bordered" id="accttable">
                                        <thead style="background-color:#cfdce1;">
                                            <tr>
                                                <th>SN</th>
                                                <th>EC</th>
                                                <th>Employee Name</th>
                                                <th>Department</th>
                                                <th>Email</th>
                                                <th>Resignation Date</th>
                                                <th>Relieving Date</th>
                                                <th>Resignation Approved</th>
                                                <th colspan="5">Clearance Status</th>  <!-- Span 5 columns for Clearance Status -->
                                            </tr>
                                            <tr>
                                                <!-- Subheaders for Clearance Status -->
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Department NOC Status</th>
                                                <th>Log NOC Status</th>
                                                <th>IT NOC Status</th>
                                                <th>HR NOC Status</th>
                                                <th>Account NOC Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($approvedEmployees as $index => $data)
                                              
                                                  
                                                        <tr>
                                                        <td>{{ $index + 1 }}.</td>
                                                        <td>{{ $data->EmpCode }}</td>
                                                        <td>{{ $data->Fname }} {{ $data->Sname }} {{ $data->Lname }}</td>
                                                        <td>{{ $data->department_name }}</td>
                                                        <td>{{ $data->EmailId_Vnr }}</td>
                                                        <td>{{ $data->Emp_ResignationDate ? \Carbon\Carbon::parse($data->Emp_ResignationDate)->format('j F Y') : 'Not specified' }}</td>
                                                        <td>{{ $data->Emp_RelievingDate ? \Carbon\Carbon::parse($data->Emp_RelievingDate)->format('j F Y') : 'Not specified' }}</td>
                                                        <td>
                                                            <span class="{{ $data->Rep_Approved == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->Rep_Approved == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->Department_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->Department_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->Log_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->Log_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->IT_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->IT_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="{{ $data->HR_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                                {{ $data->HR_NOC == 'Y' ? 'Approved' : 'Pending' }}
                                                            </span>
                                                        </td>
                                                        
                                                    <td>
                                                    <span class="{{ $data->Acc_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
                                                        @if($data->Acc_NOC == 'Y')
                                                            Approved
                                                        @elseif($data->Acc_NOC == 'N')
                                                            @php
                                                                // Fetch the record from the hrm_employee_separation_nocacc table using EmpSepId
                                                                $nocRecord = \DB::table('hrm_employee_separation_nocacc')->where('EmpSepId', $data->EmpSepId)->first();
                                                            @endphp

                                                            @if($nocRecord && $nocRecord->draft_submit_acct === 'Y')
                                                                Draft
                                                            @else
                                                                Pending
                                                            @endif
                                                        @endif
                                                    </span>
                                                </td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>