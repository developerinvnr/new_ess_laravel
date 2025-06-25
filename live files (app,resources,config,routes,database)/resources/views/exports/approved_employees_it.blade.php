<table class="table table-bordered" id="ittable">
               <!-- Only show <thead> for separation table if user matches the Rep_EmployeeID -->
               <thead>
   <tr>
      <th>EC</th>
      <th>Employee Name</th>
      <th>Department</th>
      <th>Email</th>
      <th>Resignation Date</th>
      <th>Relieving Date</th>
      <th>Resignation Approved</th>
      <th>Department NOC Status</th>
      <th>Log NOC Status</th>
      <th>IT NOC Status</th>
      <th>HR NOC Status</th>
      <th>Account NOC Status</th>
   </tr>
</thead>
<tbody>
   @foreach($approvedEmployees as $data)
   <tr>
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
      <!-- Department NOC Status -->
      <td>
         <span class="{{ $data->Rep_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->Rep_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>
      <!-- Log NOC Status -->
      <td>
         <span class="{{ $data->Log_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->Log_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>

      </td>
      <!-- IT NOC Status -->
      <!--<td>
         <span class="{{ $data->IT_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->IT_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>-->
      <td>
                            @php
                                $nocRecord = \DB::table('hrm_employee_separation_nocit')->where('EmpSepId', $data->EmpSepId)->first();
                            @endphp

                            @if($nocRecord)
                                @if($nocRecord->draft_submit_it === 'Y')
                                    <span class="text-warning">Draft</span>
                                @elseif($nocRecord->final_submit_it === 'Y')
                                    <span class="text-success">Submitted</span>
                                @elseif($data->IT_NOC == 'Y')
                                    <span class="text-success">Submitted</span>
                                @elseif($data->IT_NOC == 'N')
                                    <span class="text-warning">Pending</span>
                                @endif
                            @else
                                <span class="text-warning">Pending</span>
                            @endif
                        </td>
      <!-- HR NOC Status -->
      <td>
         <span class="{{ $data->HR_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->HR_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>
      <!-- Account NOC Status -->
      <td>
         <span class="{{ $data->Acc_NOC == 'Y' ? 'text-success' : 'text-warning' }}">
            {{ $data->Acc_NOC == 'Y' ? 'Approved' : 'Pending' }}
         </span>
      </td>
    
   </tr>
   @endforeach
</tbody>

            </table>