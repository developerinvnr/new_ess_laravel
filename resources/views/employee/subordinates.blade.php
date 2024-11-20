<!-- <ul>
    @foreach($employeeChain as $subordinate)
        @if($subordinate->RepEmployeeID == $parentEmployeeID)
            <li>
                <div class="emp">
                <a href="javascript:void(0);" class="user-info">

                    <img src="https://eu.ui-avatars.com/api/?name={{ $subordinate->Fname }}&background=A585A3&color=fff&bold=true&length=1&font-size=0.5"
                        alt="user-img" style="height: 40px;
                    width: 40px;
                    object-fit: cover;
                    border: none;
                    border-radius: 50%;">

                    </a>
                    <br>{{ $subordinate->Fname }} {{ $subordinate->Lname }}<br>
                    <span>{{ $subordinate->Sname }}<br>{{ $subordinate->DesigName }}<br>[{{ $subordinate->DepartmentName }}]</span>
                </div>

                 Recursively render the subordinates of this subordinate 
                @include('employee.subordinates', ['employeeChain' => $employeeChain, 'parentEmployeeID' => $subordinate->EmployeeID])
            </li>
        @endif
    @endforeach
</ul> -->
